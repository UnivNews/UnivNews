<?php

namespace Tests\Feature;

use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthorApplicationEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_boxes_in_correct_order(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertOk();

        $content = $response->getContent();

        // 1. Profile Information
        $posProfile = strpos($content, 'Profile Information');
        // 2. Security & Password
        $posPassword = strpos($content, 'Security & Password');
        // 3. Author Program & Portal Access
        $posAuthor = strpos($content, 'Author Program & Portal Access');
        // 4. Help Center, Information & Policies
        $posHelpCenter = strpos($content, 'Help Center, Information & Policies');
        // 5. Danger Zone
        $posDangerZone = strpos($content, 'Danger Zone');

        $this->assertNotFalse($posProfile, 'Profile Information box not found');
        $this->assertNotFalse($posPassword, 'Security & Password box not found');
        $this->assertNotFalse($posAuthor, 'Author Program box not found');
        $this->assertNotFalse($posHelpCenter, 'Help Center box not found');
        $this->assertNotFalse($posDangerZone, 'Danger Zone box not found');

        // Verify ordering: Profile < Password < Author Program < Help Center < Danger Zone
        $this->assertTrue(
            $posProfile < $posPassword,
            'Profile Information must be above Password'
        );
        $this->assertTrue(
            $posPassword < $posAuthor,
            'Password must be directly above Author Program (Author Program must be below Password)'
        );
        $this->assertTrue(
            $posAuthor < $posHelpCenter,
            'Author Program must be above Help Center'
        );
        $this->assertTrue(
            $posHelpCenter < $posDangerZone,
            'Help Center must be directly above Danger Zone'
        );
    }

    public function test_unverified_gmail_reader_sees_mailbox_verification_options(): void
    {
        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertOk();

        // Gmail is recognized
        $response->assertSee('Google (Gmail) Account Detected');
        $response->assertSee('Verify via Gmail Mailbox');
        $response->assertSee('Verify with Google Account');
        $response->assertSee('Apply as Contributor (Email Verification Required)');
    }

    public function test_non_google_reader_sees_google_account_not_found_alert(): void
    {
        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'verify@test.com',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertOk();

        // Non-Google email triggers not found notice
        $response->assertSee('Google Account Not Found');
        $response->assertSee('Check if Email Exists on Google');
        $response->assertSee('Apply as Contributor (Google Email Required)');
        $response->assertDontSee('Verify via Gmail Mailbox');
    }

    public function test_check_google_email_api_endpoint(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
        ]);

        // Test with Gmail address
        $response = $this->actingAs($user)->getJson(route('profile.check-google-email', ['email' => 'testuser@gmail.com']));
        $response->assertOk();
        $response->assertJson(['is_google' => true]);

        // Test with non-Google address
        $response = $this->actingAs($user)->getJson(route('profile.check-google-email', ['email' => 'unknown@test.com']));
        $response->assertOk();
        $response->assertJson(['is_google' => false]);
    }

    public function test_verified_google_reader_sees_verified_status_and_active_apply_button(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertOk();

        $response->assertSee('Email Verified');
        $response->assertSee('Apply as Contributor');
        $response->assertDontSee('Apply as Contributor (Email Verification Required)');
    }

    public function test_unverified_reader_cannot_access_author_application_page(): void
    {
        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
        ]);

        $response = $this->actingAs($user)->get(route('author.apply'));

        // Redirects to profile page with error message
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('error');
    }

    public function test_non_google_verified_reader_cannot_access_author_application_page(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@test.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('author.apply'));

        // Redirects to profile page requiring a Google email
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('error');
    }

    public function test_unverified_reader_cannot_submit_author_application(): void
    {
        $university = University::create([
            'name' => 'University of Indonesia',
            'abbreviation' => 'UI',
            'slug' => 'ui',
        ]);

        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
        ]);

        $response = $this->actingAs($user)->post(route('author.apply'), [
            'name' => 'John Reader',
            'university_id' => $university->id,
            'department' => 'Computer Science',
            'author_bio' => 'This is a long statement to apply for being a contributor in University News portal.',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('error');

        $this->assertSame(User::STATUS_NONE, $user->fresh()->author_status);
    }

    public function test_verified_google_reader_can_access_author_application_page(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'author@gmail.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('author.apply'));
        $response->assertOk();
    }

    public function test_verified_google_reader_can_submit_author_application(): void
    {
        $university = University::create([
            'name' => 'University of Indonesia',
            'abbreviation' => 'UI',
            'slug' => 'ui',
        ]);

        $user = User::factory()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'author@gmail.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('author.apply'), [
            'name' => 'John Reader',
            'university_id' => $university->id,
            'department' => 'Computer Science',
            'author_bio' => 'This is a long statement to apply for being a contributor in University News portal.',
        ]);

        $response->assertRedirect(route('author.apply.confirmation'));
        $this->assertSame(User::STATUS_PENDING, $user->fresh()->author_status);
    }

    public function test_gmail_reader_can_request_verification_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'reader@gmail.com',
        ]);

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->post(route('verification.send'));

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'verification-link-sent');
    }

    public function test_non_google_reader_is_blocked_from_requesting_verification_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create([
            'role' => User::ROLE_PUBLIC,
            'email' => 'random@test.com',
        ]);

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->post(route('verification.send'));

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('error');
    }
}

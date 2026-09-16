<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminAndAuthorEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $author;
    protected University $university;

    protected function setUp(): void
    {
        parent::setUp();

        $this->university = University::create([
            'name'         => 'University of Indonesia',
            'abbreviation' => 'UI',
        ]);

        $this->admin = User::factory()->create([
            'role'              => User::ROLE_ADMIN,
            'author_status'     => User::STATUS_APPROVED,
            'university_id'     => $this->university->id,
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
        ]);

        $this->author = User::factory()->create([
            'role'              => User::ROLE_AUTHOR,
            'author_status'     => User::STATUS_APPROVED,
            'university_id'     => $this->university->id,
            'email'             => 'author@gmail.com',
            'email_verified_at' => now(),
        ]);
    }

    public function test_admin_settings_displays_dedicated_email_field_and_verification_badge(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.settings.edit'));

        $response->assertOk();
        $response->assertSee('Account Email Address');
        $response->assertSee('admin@gmail.com');
        $response->assertSee('Email Verified');
    }

    public function test_admin_unverified_gmail_displays_verification_options(): void
    {
        $this->admin->email_verified_at = null;
        $this->admin->save();

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.settings.edit'));

        $response->assertOk();
        $response->assertSee('Google (Gmail) Account Detected — Unverified');
        $response->assertSee('Verify via Gmail Mailbox');
        $response->assertSee('Verify with Google Account');
    }

    public function test_admin_non_google_email_displays_account_not_found_alert(): void
    {
        $this->admin->email = 'admin@customdomain.internal';
        $this->admin->email_verified_at = null;
        $this->admin->save();

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.settings.edit'));

        $response->assertOk();
        $response->assertSee('Google Account Not Found');
        $response->assertSee('Check if Email Exists on Google');
        $response->assertSee('Connect with Google (Gmail)');
    }

    public function test_admin_can_update_profile_and_email_change_resets_verification(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->put(route('admin.settings.update'), [
            'name'  => 'Updated Admin Name',
            'email' => 'new.admin@gmail.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->admin->refresh();
        $this->assertSame('Updated Admin Name', $this->admin->name);
        $this->assertSame('new.admin@gmail.com', $this->admin->email);
        $this->assertNull($this->admin->email_verified_at);
    }

    public function test_admin_can_send_verification_notification_for_gmail(): void
    {
        Notification::fake();

        $this->admin->email = 'admin.notice@gmail.com';
        $this->admin->email_verified_at = null;
        $this->admin->save();

        $response = $this->actingAs($this->admin, 'admin')->post(route('verification.send'));

        $response->assertSessionHas('status', 'verification-link-sent');
        Notification::assertSentTo($this->admin, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    public function test_admin_blocked_from_sending_verification_to_non_google_email(): void
    {
        Notification::fake();

        $this->admin->email = 'admin@non-google-domain.test';
        $this->admin->email_verified_at = null;
        $this->admin->save();

        $response = $this->actingAs($this->admin, 'admin')->post(route('verification.send'));

        $response->assertSessionHas('error');
        Notification::assertNothingSent();
    }

    public function test_author_settings_displays_email_field_and_verification_badge(): void
    {
        $response = $this->actingAs($this->author)->get(route('author.settings.edit'));

        $response->assertOk();
        $response->assertSee('Email Address');
        $response->assertSee('author@gmail.com');
        $response->assertSee('Email Verified');
    }

    public function test_author_cms_navigation_displays_profile_instead_of_settings(): void
    {
        $response = $this->actingAs($this->author)->get(route('author.dashboard'));

        $response->assertOk();
        $response->assertSee('Profile');
        $response->assertSee(route('author.settings.edit'));
        $this->assertStringNotContainsString(route('author.settings.edit') . "\"\n                   class=\"flex items-center px-6 py-3.5 text-sm font-medium transition-colors text-gray-300 hover:bg-white/5 hover:text-white\">\n                    <svg class=\"w-5 h-5 mr-3.5 opacity-90\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">\n                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\"/>\n                    </svg>\n                    Settings", $response->getContent());
    }

    public function test_author_unverified_gmail_displays_verification_options(): void
    {
        $this->author->email_verified_at = null;
        $this->author->save();

        $response = $this->actingAs($this->author)->get(route('author.settings.edit'));

        $response->assertOk();
        $response->assertSee('Google (Gmail) Account Detected — Unverified');
        $response->assertSee('Verify via Gmail Mailbox');
        $response->assertSee('Verify with Google Account');
    }

    public function test_author_can_update_profile_and_email_change_resets_verification(): void
    {
        $response = $this->actingAs($this->author)->put(route('author.settings.update'), [
            'name'         => 'Updated Author Name',
            'email'        => 'new.author@gmail.com',
            'phone_number' => '+62 812-9999-8888',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->author->refresh();
        $this->assertSame('Updated Author Name', $this->author->name);
        $this->assertSame('new.author@gmail.com', $this->author->email);
        $this->assertSame('+62 812-9999-8888', $this->author->phone_number);
        $this->assertNull($this->author->email_verified_at);
    }

    public function test_author_can_send_verification_notification_for_gmail(): void
    {
        Notification::fake();

        $this->author->email = 'author.notice@gmail.com';
        $this->author->email_verified_at = null;
        $this->author->save();

        $response = $this->actingAs($this->author)->post(route('verification.send'));

        $response->assertSessionHas('status', 'verification-link-sent');
        Notification::assertSentTo($this->author, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    public function test_admin_site_content_contact_info_remains_independent_and_functional(): void
    {
        Setting::set('contact_whatsapp', '+6281234567890');
        Setting::set('contact_email', 'contact@universitynews.edu');
        Setting::set('contact_address', '123 Academic Way, University Plaza');

        // Verify contact edit page loads with separate contact settings
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.pages.contact.edit'));
        $response->assertOk();
        $response->assertSee('Edit Contact Info');
        $response->assertSee('+6281234567890');
        $response->assertSee('contact@universitynews.edu');
        $response->assertSee('123 Academic Way, University Plaza');

        // Update contact info and verify it does NOT modify admin user account email
        $postResponse = $this->actingAs($this->admin, 'admin')->put(route('admin.pages.contact.update'), [
            'contact_whatsapp' => '+628999888777',
            'contact_email'    => 'new.contact@universitynews.edu',
            'contact_address'  => '456 New Campus Boulevard',
        ]);

        $postResponse->assertSessionHas('success');

        // Admin account email must remain unchanged
        $this->admin->refresh();
        $this->assertSame('admin@gmail.com', $this->admin->email);

        // Setting values must be updated
        $this->assertSame('+628999888777', Setting::get('contact_whatsapp'));
        $this->assertSame('new.contact@universitynews.edu', Setting::get('contact_email'));
        $this->assertSame('456 New Campus Boulevard', Setting::get('contact_address'));
    }
}

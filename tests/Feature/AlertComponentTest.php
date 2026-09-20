<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlertComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_alert_toast_container()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="reui-alert-container"', false);
        $response->assertSee('window.showInfoAlert', false);
        $response->assertSee('window.showAlert', false);
    }

    public function test_footer_social_links_use_show_info_alert()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("window.showInfoAlert('Info! Link coming soon'", false);
        $response->assertSee("window.showInfoAlert('Info! Feature coming soon'", false);
        $response->assertDontSee("onclick=\"alert('Link coming soon');\"", false);
    }

    public function test_x_alert_blade_component_renders_properly()
    {
        $view = $this->blade(
            '<x-alert variant="info" title="Info! Something important">This is an important message. Please read it carefully.</x-alert>'
        );

        $view->assertSee('Info! Something important');
        $view->assertSee('This is an important message. Please read it carefully.');
        $view->assertSee('text-[#a855f7]', false);
        $view->assertSee('rounded-[12px]', false);
    }
}

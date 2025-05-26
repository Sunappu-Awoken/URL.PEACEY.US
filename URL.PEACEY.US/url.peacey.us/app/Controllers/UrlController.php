<?php
namespace App\Controllers;

use App\Core\Controller;
// No longer using Url model for landing data; wiring up directly here.
class UrlController extends Controller
{
    public function landing()
    {
        // Build all landing page data dynamically
        $data = [
            'logo'            => base_url('assets/images/peaceySystems-logo.png'),
            'logo_alt'        => 'Peacey Systems Logo',
            'headline'        => 'Shorten, Track & Share URLs Effortlessly',
            'subheadline'     => 'A blazing-fast, secure URL shortener built for developers and teams.',
            'cta_text'        => 'Get Started—It’s Free',
            'cta_link'        => site_url('signup'),
            'features'        => [
                [
                    'title'       => 'Ultra-Fast Redirects',
                    'description' => 'Our CDN-backed service resolves your links in milliseconds, everywhere.',
                ],
                [
                    'title'       => 'Detailed Analytics',
                    'description' => 'Track clicks, geolocation, referrers and more with real-time dashboards.',
                ],
                [
                    'title'       => 'Custom Domains',
                    'description' => 'Use your own branded domain for total brand consistency.',
                ],
            ],
            'steps'           => [
                ['number' => 1, 'description' => 'Paste your long URL into our form and click “Shorten.”'],
                ['number' => 2, 'description' => 'Copy your new, branded short link.'],
                ['number' => 3, 'description' => 'Share it anywhere—and watch live analytics roll in.'],
            ],
            'testimonials_title' => 'What Our Users Say',
            'testimonials'       => [
                [
                    'quote'   => 'Peacey Systems cut our URL-management time in half and gives us insights we never had.',
                    'author'  => 'Alex Johnson',
                    'company' => 'Acme Corp',
                ],
                // add more testimonials here as needed
            ],
        ];

        // Render the landing view with our data
        $this->view('url/landing', ['data' => $data]);
    }
}

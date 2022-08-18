<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Signup;

class CheckSignupWebsite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $signup;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Signup $signup)
    {
        $this->signup = $signup;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->signup->email) || empty($this->signup->web_site)) {
            return;
        }

        if (
            $this->domainsAreMismatching() ||
            $this->websiteIsUnreachable()
        ) {
            $this->signup->web_site_unreachable = true;
            $this->signup->save();
        }
    }

    private function domainsAreMismatching()
    {
        return strtolower(
            substr(
                $this->signup->email,
                strpos($this->signup->email, '@') + 1,
                strlen($this->signup->email)
            )
        ) !== strtolower(
            str_ireplace(
                ['http://', 'www.', 'https://', 'ftp://'],
                '',
                $this->signup->web_site
            )
        );
    }

    private function websiteIsUnreachable(): bool
    {
        try {
            $url = $this->signup->web_site;

            if (
                !Str::startsWith($url, 'http://') &&
                !Str::startsWith($url, 'https://')
            ) {
                $url = 'http://' .
                    str_ireplace([
                        'http:/',
                        'https:/',
                        'htp://',
                        'htps://',
                        'hpp://',
                        'hpps://',
                        'ftp://',
                        'ftps://',
                    ], '', $url);
            }

            $response = Http::timeout(10)->head($url);

            if ($response->successful()) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return true;
        }
    }
}

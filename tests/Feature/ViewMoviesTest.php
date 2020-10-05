<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewMoviesTest extends TestCase
{
  public function the_main_page_shows_correct_info()
  {
      Http::fake();
    $resp = $this->get(route('movies.index'));
    $resp->assertSuccessful();
    $resp->assertSee('Popular Movies');
  }
}

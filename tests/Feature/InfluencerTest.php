<?php

namespace Tests\Feature;

use App\User;
use App\Influencer;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @testdox Influencers
 * @package Tests\Feature
 * @coversDefaultClass \App\Http\Controllers\InfluencerController
 * @group   web
 * @author  herman.bukarev@noveogroup.com
 */
class InfluencerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * A basic workflow for unauthorized user.
     *
     * @covers ::index()
     * @dataProvider influencerUrlsDataProvider
     *
     * @param $path
     * @param $status
     * @return void
     */
    public function access_to_pages_by_unauthorized_user($path, $status)
    {
        $response = $this->get($path);
        $response->assertStatus($status);
    }

    /**
     * @test
     * A authenticated workflow.
     *
     * @covers ::index()
     * @dataProvider influencerUrlsDataProvider
     *
     * @param $path
     * @return void
     */
    public function access_to_pages_by_authorized_user($path)
    {
        $user = factory(User::class)->create([
            'email' => 'admin@test.test',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $this->actingAs($user)->get($path)->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * A authenticated workflow.
     *
     * @covers ::downloadIndex()
     *
     * @return void
     */
    public function pdf_downloading_by_authorized_user()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@test.test',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $this->actingAs($user)
            ->get('/influencers/download')
            ->assertHeader('content-type', 'application/pdf')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * Test influencers view
     *
     * @covers ::index()
     *
     * @return void
     */
    public function check_pagination_of_influencers_index()
    {
        $list = factory(Influencer::class, 30)->create();
        $beforeLast = factory(Influencer::class)->create(['name' => 'before last']);
        $lastOne = factory(Influencer::class)->create(['name' => 'last one']);
        $user = factory(User::class)->create([
            'email' => 'admin@test.test',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $this->actingAs($user);
        $this->get(route('influencers.list', ['page' => 1]))
            ->assertDontSee($beforeLast->name)
            ->assertDontSee($lastOne->name)
            ->assertSee($list[0]->name)
            ->assertSee($list[14]->name);

        $this->get(route('influencers.list', ['page' => 3]))
            ->assertSee($beforeLast->name)
            ->assertSee($lastOne->name)
            ->assertDontSee($list[29]->name);
    }

    /**
     * @return array
     * @uses userAuthenticate
     *
     * @uses influencersListAccessUnauthorized
     */
    public function influencerUrlsDataProvider()
    {
        return [
            ['/', Response::HTTP_OK],
            ['/influencers', Response::HTTP_FOUND],
            ['/influencers/download', Response::HTTP_FOUND],
        ];
    }

    /**
     * @return array
     * @uses influencersPagesView
     *
     */
    public function influencerPagesDataProvider()
    {
        return [
            ['number_of_influencers_to_create' => 50, 'current_page' => 3, 'expected_on_last_page' => 5],
            [10, 0, 10],
        ];
    }
}

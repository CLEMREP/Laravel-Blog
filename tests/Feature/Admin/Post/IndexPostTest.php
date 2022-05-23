<?php

namespace Tests\Feature\Admin\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class IndexUserTest extends TestCase
{
    /** @test */
    public function only_admin_can_access_index_post()
    {
        $user = User::factory()->create(['admin' => 1]);

        $this->actingAs($user)->get(route('admin.posts.index'))->assertSuccessful();
    }

    /**
     * @test
     */
    public function filter_feature_works()
    {
        $user = User::factory()->create(['admin' => 1]);
        $posts = [
            'Adrien' => Post::factory()->create(['title' => 'A', 'created_at' => now(), 'published' => 1]),
            'Bastien' => Post::factory()->create(['title' => 'B', 'created_at' => now()->addDay(1), 'published' => 0]),
            'Clément' => Post::factory()->create(['title' => 'C', 'created_at' => now()->addDay(2), 'published' => 1]),
        ];

        foreach ($this->filterDataProvider() as $case => $caseData) {

            list($params, $expected) = $caseData;

            $response = $this->actingAs($user)->get(route('admin.posts.index', $params));
            $data = $response->viewData("posts");
            
            foreach ($expected as $i => $postTitle) {
                $this->assertEquals($postTitle, $data[$i]->title, $case);
            }
        }
    }

    private function filterDataProvider(): array
    {
        return [
            'order by title asc' => [
                ['order' => 'title', 'direction' => 'asc'],
                ['A', 'B', 'C'],
            ],
            'order by title desc' =>[
                ['order' => 'title', 'direction' => 'desc'],
                ['C', 'B', 'A'],
            ],
            'order by created_at asc' =>[
                ['order' => 'created_at', 'direction' => 'asc'],
                ['A', 'B', 'C'],
            ],
            'order by created_at desc' =>[
                ['order' => 'created_at', 'direction' => 'desc'],
                ['C', 'B', 'A'],
            ],
            'published on value 1' =>[
                ['order' => 'published', 'value' => '1'],
                ['A', 'C'],
            ],
            'published on value 0' =>[
                ['order' => 'published', 'value' => '0'],
                ['B'],
            ],
        ];
    }
}

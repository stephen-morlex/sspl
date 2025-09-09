<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate tables first
        DB::table('news_tag')->delete();
        DB::table('news')->delete();
        DB::table('tags')->delete();
        DB::table('categories')->delete();

        // Create categories
        $categories = [
            ['name' => 'Transfers', 'slug' => 'transfers', 'description' => 'Latest transfer news and rumors'],
            ['name' => 'Matches', 'slug' => 'matches', 'description' => 'Match previews, reports and analysis'],
            ['name' => 'Injuries', 'slug' => 'injuries', 'description' => 'Player injury updates and recovery news'],
            ['name' => 'Opinion', 'slug' => 'opinion', 'description' => 'Editorials and opinion pieces'],
        ];

        foreach ($categories as $categoryData) {
            Category::create(array_merge($categoryData, [
                'id' => (string) Str::ulid(),
            ]));
        }

        // Create tags
        $tags = [
            ['name' => 'Premier League', 'slug' => 'premier-league', 'description' => 'Premier League news'],
            ['name' => 'La Liga', 'slug' => 'la-liga', 'description' => 'La Liga news'],
            ['name' => 'Bundesliga', 'slug' => 'bundesliga', 'description' => 'Bundesliga news'],
            ['name' => 'Serie A', 'slug' => 'serie-a', 'description' => 'Serie A news'],
            ['name' => 'Ligue 1', 'slug' => 'ligue-1', 'description' => 'Ligue 1 news'],
            ['name' => 'Champions League', 'slug' => 'champions-league', 'description' => 'UEFA Champions League news'],
            ['name' => 'Transfers', 'slug' => 'transfers-2', 'description' => 'Transfer news and rumors'], // Changed slug to avoid conflict
            ['name' => 'Injuries', 'slug' => 'injuries-2', 'description' => 'Player injury updates'], // Changed slug to avoid conflict
        ];

        foreach ($tags as $tagData) {
            Tag::create(array_merge($tagData, [
                'id' => (string) Str::ulid(),
            ]));
        }

        // Get all categories and tags
        $allCategories = Category::all();
        $allTags = Tag::all();

        // Create news articles
        $newsArticles = [
            [
                'title' => 'Major Transfer Deal Confirmed',
                'slug' => 'major-transfer-deal-confirmed',
                'excerpt' => 'A major transfer deal has been confirmed between two top clubs.',
                'content' => '<p>In a stunning development, a major transfer deal has been confirmed today between two top clubs. The player in question has agreed to terms and will undergo a medical shortly.</p><p>Details of the transfer fee and contract length are expected to be announced later this afternoon.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Match Preview: Big Game This Weekend',
                'slug' => 'match-preview-big-game-this-weekend',
                'excerpt' => 'This weekend\'s big match promises to be an exciting encounter.',
                'content' => '<p>This weekend\'s big match promises to be an exciting encounter between two of the league\'s top teams. Both sides are in good form and will be looking to secure all three points.</p><p>Our expert analysis looks at the key battles that could decide the outcome of this crucial match.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Star Player Suffers Injury Setback',
                'slug' => 'star-player-suffers-injury-setback',
                'excerpt' => 'The team\'s star player has suffered a significant injury setback.',
                'content' => '<p>The team\'s star player has suffered a significant injury setback that could keep him out for several weeks. The injury occurred during training yesterday and scans are expected to confirm the extent of the damage.</p><p>The team\'s medical staff are working closely with the player to develop a recovery plan.</p>',
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($newsArticles as $article) {
            $news = News::create(array_merge($article, [
                'id' => (string) Str::ulid(),
                'category_id' => $allCategories->random()->id,
            ]));

            // Attach random tags manually without the id column
            $selectedTags = $allTags->random(rand(2, 4));
            foreach ($selectedTags as $tag) {
                DB::table('news_tag')->insert([
                    'news_id' => $news->id,
                    'tag_id' => $tag->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
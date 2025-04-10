<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Comment;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample topics and content
        $topics = [
            [
                'title' => 'Team Work Tracking System Development',
                'content' => '<p>Hello everyone, I would like to share our experience with developing a team work tracking system in our organization. 
                We faced issues with tracking progress of individual tasks and not knowing who is doing what, so we thought of developing this system. 
                I hope this might be useful for those looking for team management methods.</p>
                <p>Does anyone have recommendations about software or tools?</p>',
                'is_anonymous' => false,
                'author_name' => 'Thomas Jordan',
                'comments_count' => 15
            ],
            [
                'title' => 'Suggestions for Improving Internal Communication',
                'content' => '<p>From my observations over a period of time, I think we have significant issues with internal communication. Sometimes important decisions are made but not communicated thoroughly, or new policies are introduced without detailed explanation.</p>
                <p>I would like to suggest a better notification system, perhaps a mobile app or platform that everyone can easily access. Does anyone have additional opinions?</p>',
                'is_anonymous' => true,
                'author_name' => null,
                'comments_count' => 22
            ],
            [
                'title' => 'Guidelines for Working in Cross-Functional Teams',
                'content' => '<p>Our team consists of people from various departments working together on a single project, but we face challenges in coordination and prioritizing tasks.</p>
                <p>Has anyone had experience working in this kind of setup, and are there techniques or frameworks that help things run more smoothly? I would appreciate any advice.</p>',
                'is_anonymous' => false,
                'author_name' => 'Patricia Morgan',
                'comments_count' => 18
            ],
            [
                'title' => 'Improving Presentation Skills for the Team',
                'content' => '<p>Since our team frequently presents to clients and executives, I\'ve noticed that many still lack confidence in presenting.</p>
                <p>Should we organize training or workshops on effective presentation? Or are there other methods to develop this skill? I would like to hear everyone\'s opinions.</p>',
                'is_anonymous' => false,
                'author_name' => 'Karen Wilson',
                'comments_count' => 7
            ],
            [
                'title' => 'Managing Workplace Stress',
                'content' => '<p>Recently I feel many team members are experiencing high stress due to urgent work and tight deadlines.</p>
                <p>I think we should have activities or guidelines for managing stress and taking care of team mental health. Does anyone have ideas or has tried something that worked well?</p>',
                'is_anonymous' => true,
                'author_name' => null,
                'comments_count' => 25
            ],
            [
                'title' => 'Guidelines for Improving Performance Evaluation System',
                'content' => '<p>The current performance evaluation system seems to not cover all dimensions of work. Sometimes it feels unfair and doesn\'t reflect actual work.</p>
                <p>I would like to know what everyone thinks about the current system and what suggestions you might have to improve it? Should we adopt new OKRs or KPIs?</p>',
                'is_anonymous' => false,
                'author_name' => 'Theodore Williams',
                'comments_count' => 20
            ],
            [
                'title' => 'Company New Year Party Planning',
                'content' => '<p>How should we organize this year\'s New Year party? Where should we hold it, what theme, and what activities should we have?</p>
                <p>I would like opinions from everyone to make this year\'s event fun and memorable. I want everyone to participate in sharing ideas.</p>',
                'is_anonymous' => false,
                'author_name' => 'Susan Parker',
                'comments_count' => 30
            ],
            [
                'title' => 'Energy Conservation Guidelines in the Office',
                'content' => '<p>Given the rising electricity costs and the company\'s environmental policies, how should we approach energy conservation in the office?</p>
                <p>Does anyone have interesting ideas or approaches? I would like methods that everyone can actually implement and see clear results.</p>',
                'is_anonymous' => false,
                'author_name' => 'Peter Thompson',
                'comments_count' => 12
            ],
            [
                'title' => 'Fundraising for Charity Activities',
                'content' => '<p>I would like to propose that our company organize fundraising for charity, such as donating to schools in need or helping natural disaster victims.</p>
                <p>Is anyone interested in being part of the working committee? And do you have ideas about what we could do? I would like this to be an activity where everyone participates and sees real results.</p>',
                'is_anonymous' => false,
                'author_name' => 'James Peterson',
                'comments_count' => 16
            ],
            [
                'title' => 'English Skill Development for Employees',
                'content' => '<p>As our company has more foreign clients, English skills are very important, but I\'ve found that many still lack confidence in communication.</p>
                <p>Should we have English classes or activities to develop this skill? Has anyone had experience or can recommend effective learning methods?</p>',
                'is_anonymous' => false,
                'author_name' => 'Melissa Johnson',
                'comments_count' => 19
            ],
        ];

        // Create sample topics
        foreach ($topics as $topicData) {
            $comments_count = $topicData['comments_count'] ?? 0;
            unset($topicData['comments_count']);
            
            $topic = Topic::create($topicData);
            
            // Create sample comments for each topic
            for ($i = 1; $i <= $comments_count; $i++) {
                Comment::create([
                    'topic_id' => $topic->id,
                    'content' => $this->generateRandomComment($i),
                    'author_name' => $this->getRandomName(),
                    'is_anonymous' => rand(0, 1) === 1,
                ]);
            }
        }
    }
    
    /**
     * Generate random comment
     */
    private function generateRandomComment($index): string
    {
        $comments = [
            'Thank you for sharing this information, it\'s very useful.',
            'I agree with this proposal, I think it will truly help develop our organization.',
            'I would like more details about practical implementation.',
            'I\'ve had similar experiences before, and I would recommend proceeding with caution.',
            'Great idea, I fully support this and am willing to help if needed.',
            'I have an additional question: when will we start implementing this and what\'s the budget?',
            'I recommend studying other successful organizations in this area.',
            'I feel we still lack important information, more research is needed.',
            'I strongly agree, and would add that we should do this consistently.',
            'Interesting, but I\'m concerned about the long-term impact on the team.',
            'Thank you for bringing up this issue, it\'s something we should have discussed long ago.',
            'I have experience in this area and am happy to share knowledge with everyone.',
            'This will need support from management to succeed.',
            'I agree, but think we should proceed step by step.',
            'This issue is more complex than it appears, we should discuss it further.',
            'I would like follow-up after implementation begins.',
            'This is important and will greatly help develop our organization.',
            'I feel we\'re not ready for this change yet, we should prepare more.',
            'I suggest organizing a meeting specifically to discuss this.',
            'This concept is interesting but may need to be adapted to our context.',
            'I see this as a good opportunity to develop new skills.',
            'We should start with a pilot project before expanding.',
            'I\'ve done this at my previous company with great results.',
            'We should survey everyone\'s opinions before proceeding.',
            'This issue involves multiple departments, we should have representatives from all departments in the discussion.',
            'I volunteer to help with this project if needed.',
            'We should set clear, measurable goals.',
            'We should have more knowledge and experience exchange between teams.',
            'There should be clear and continuous communication at every step.',
            'I see this as an important step in developing our organization.',
        ];
        
        // Randomly select a comment from the list
        $randomComment = $comments[array_rand($comments)];
        
        // Add additional text as appropriate
        if ($index % 5 === 0) {
            $randomComment .= ' This is very important, thank you for bringing it up for discussion.';
        } elseif ($index % 3 === 0) {
            $randomComment .= ' I suggest continuous monitoring of the results.';
        }
        
        return $randomComment;
    }
    
    /**
     * Generate random name
     */
    private function getRandomName(): string
    {
        $firstNames = ['John', 'Emily', 'Michael', 'Jessica', 'David', 'Sarah', 'Robert', 'Jennifer', 'William', 'Linda', 'Richard', 'Elizabeth', 'Joseph', 'Barbara', 'Thomas', 'Susan', 'Charles', 'Jessica', 'Daniel', 'Margaret'];
        
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }
}

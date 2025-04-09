<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topic1 = Topic::where('title', 'Company trip survey')->first();
        $topic3 = Topic::where('title', 'New Transportation benefits')->first();
        
        if ($topic1) {
            $comments = [
                [
                    'topic_id' => $topic1->id,
                    'content' => 'ผมคิดว่าเกาะช้างเป็นตัวเลือกที่ดี มีกิจกรรมให้ทำมากมายและเหมาะกับทุกคนในทีม',
                    'author_name' => 'สมศักดิ์',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(9),
                    'updated_at' => now()->subDays(9),
                ],
                [
                    'topic_id' => $topic1->id,
                    'content' => 'ขอเสนอภูเก็ตค่ะ มีทั้งทะเล และกิจกรรมสันทนาการหลากหลาย ตอบโจทย์การทำ team building',
                    'author_name' => 'วรรณา',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(8),
                    'updated_at' => now()->subDays(8),
                ],
                [
                    'topic_id' => $topic1->id,
                    'content' => 'ผมคิดว่าเชียงใหม่น่าสนใจ อากาศดี และมีกิจกรรมเชิงวัฒนธรรมที่น่าสนใจ ช่วยสร้างประสบการณ์ที่แตกต่าง',
                    'author_name' => 'ประพนธ์',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(7),
                    'updated_at' => now()->subDays(7),
                ],
                [
                    'topic_id' => $topic1->id,
                    'content' => 'เห็นด้วยกับคุณประพนธ์ เชียงใหม่เป็นทางเลือกที่ดี ทั้งเรื่องอาหาร ที่พัก และกิจกรรม',
                    'author_name' => 'สุรีย์',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(6),
                    'updated_at' => now()->subDays(6),
                ],
                [
                    'topic_id' => $topic1->id,
                    'content' => 'ผมคิดว่าเราควรไปที่ที่ไม่ร้อนมากเกินไป เพราะบางคนมีปัญหาเรื่องสุขภาพ แต่ขอให้มีกิจกรรมทีมที่สนุกๆ',
                    'author_name' => null,
                    'is_anonymous' => true,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
            ];
            
            foreach ($comments as $comment) {
                $commentModel = Comment::create($comment);
                $topic1->increment('comments_count');
            }
        }
        
        if ($topic3) {
            $comments = [
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ควรมีรถรับส่งจากสถานี BTS อโศก เพราะมีพนักงานมาทำงานจากเส้นทางนี้เยอะ',
                    'author_name' => 'ปริญญา',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ควรมีรถจากฝั่งธนบุรีด้วยค่ะ',
                    'author_name' => 'สุทัศนา',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'เสนอให้มีจากสถานี MRT พระราม 9 ครับ มีพนักงานมาจากเส้นทางนี้หลายคน',
                    'author_name' => 'อนุชา',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ขอเสนอสถานีรถไฟฟ้าเพชรบุรีค่ะ อยู่กลางเมือง',
                    'author_name' => 'มาลี',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ขอสถานี MRT ลาดพร้าวด้วย มีพนักงานหลายคนอยู่แถวนั้น และมีหอพักราคาไม่แพงด้วย',
                    'author_name' => 'มนัส',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ผมคิดว่าควรรวมเส้นทางรถรับส่งให้ครอบคลุมพื้นที่ที่มีพนักงานอาศัยอยู่มากที่สุด และอาจทำแบบสำรวจเพิ่มเติมเพื่อให้ได้ข้อมูลที่แม่นยำ',
                    'author_name' => 'Jim',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ผมว่าตามใจฝ่ายบริหารเลยครับ ทางไหนก็ได้ ขอให้มีเถอะ',
                    'author_name' => 'Jimmy',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(0),
                    'updated_at' => now()->subDays(0),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ถ้ามีรถรับส่งอาจช่วยลดปัญหาการมาทำงานสายได้ด้วย และช่วยลดการปล่อยมลพิษ เพราะพนักงานไม่ต้องขับรถส่วนตัวมา',
                    'author_name' => 'ภานุวัฒน์',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(0),
                    'updated_at' => now()->subDays(0),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'เสนอว่าควรมีรถทั้งรอบเช้าและรอบเย็น ไม่ใช่แค่รอบเช้าอย่างเดียว',
                    'author_name' => 'สุภาพร',
                    'is_anonymous' => false,
                    'created_at' => now()->subDays(0),
                    'updated_at' => now()->subDays(0),
                ],
                [
                    'topic_id' => $topic3->id,
                    'content' => 'ผมว่าแทนที่จะมีรถรับส่ง อาจจะให้เงินสนับสนุนค่าเดินทางเพิ่มก็ได้ จะได้มีความยืดหยุ่นมากกว่า และบริษัทไม่ต้องแบกรับค่าใช้จ่ายรถ',
                    'author_name' => null,
                    'is_anonymous' => true,
                    'created_at' => now()->subDays(0),
                    'updated_at' => now()->subDays(0),
                ],
            ];
            
            foreach ($comments as $comment) {
                $commentModel = Comment::create($comment);
                $topic3->increment('comments_count');
            }
        }
    }
}

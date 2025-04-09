<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            [
                'title' => 'Company trip survey',
                'content' => 'เราอยากทราบความคิดเห็นของพนักงานทุกคนเกี่ยวกับสถานที่สำหรับการท่องเที่ยวบริษัทประจำปีนี้ กรุณาแสดงความคิดเห็นของคุณในหัวข้อนี้',
                'author_name' => 'HR Team',
                'is_anonymous' => false,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Introduce new member for Sales team!',
                'content' => 'ยินดีต้อนรับคุณสมชาย สุขดี เข้าร่วมทีมขายในตำแหน่ง Senior Sales Representative คุณสมชายมีประสบการณ์ในวงการขายซอฟต์แวร์มากว่า 10 ปี และเป็นผู้เชี่ยวชาญด้านการสร้างและรักษาความสัมพันธ์กับลูกค้า',
                'author_name' => 'มานพ วัฒนา',
                'is_anonymous' => false,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'New Transportation benefits',
                'content' => 'บริษัทกำลังพิจารณาจัดให้มีรถรับส่งพนักงานระหว่างสถานีรถไฟฟ้ามาที่บริษัท ช่วยแสดงความคิดเห็นว่าคุณต้องการเส้นทางใดบ้าง',
                'author_name' => 'ฝ่ายบุคคล',
                'is_anonymous' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ];

        foreach ($topics as $topic) {
            Topic::create($topic);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Turkey
        Destination::create([
            'name_ar' => 'تركيا',
            'name_en' => 'Turkey',
            'description_ar' => 'وجهة سياحية رائعة تجمع بين التاريخ العريق والطبيعة الخلابة',
            'description_en' => 'Amazing tourist destination combining rich history and stunning nature',
            'currency' => 'الليرة التركية',
            'exchange_rate' => 7.5000,
            'min_daily_budget' => 300,
            'max_daily_budget' => 500,
            'image_url' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'primary',
            'badge_text_ar' => 'شعبية',
            'badge_text_en' => 'Popular',
            'is_popular' => true,
            'best_months' => json_encode(['أبريل', 'مايو', 'يونيو', 'سبتمبر', 'أكتوبر']),
            'weather_types' => json_encode(['معتدل', 'دافئ ومشمس']),
            'trip_types' => json_encode(['عائلية', 'ثقافية', 'تسوق', 'رومانسية']),
        ]);

        // Malaysia
        Destination::create([
            'name_ar' => 'ماليزيا',
            'name_en' => 'Malaysia',
            'description_ar' => 'جنة استوائية تناسب العائلات مع ثقافة متنوعة وطبيعة ساحرة',
            'description_en' => 'Tropical paradise perfect for families with diverse culture and charming nature',
            'currency' => 'الرينجت الماليزي',
            'exchange_rate' => 1.1500,
            'min_daily_budget' => 250,
            'max_daily_budget' => 400,
            'image_url' => 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'success',
            'badge_text_ar' => 'ممتازة للعائلات',
            'badge_text_en' => 'Great for Families',
            'is_popular' => true,
            'best_months' => json_encode(['مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس']),
            'weather_types' => json_encode(['دافئ ومشمس', 'استوائي']),
            'trip_types' => json_encode(['عائلية', 'مغامرة', 'تسوق', 'استجمام']),
        ]);

        // Georgia
        Destination::create([
            'name_ar' => 'جورجيا',
            'name_en' => 'Georgia',
            'description_ar' => 'وجهة اقتصادية مذهلة مع جبال خلابة وثقافة فريدة',
            'description_en' => 'Amazing budget destination with stunning mountains and unique culture',
            'currency' => 'اللاري الجورجي',
            'exchange_rate' => 0.7500,
            'min_daily_budget' => 200,
            'max_daily_budget' => 350,
            'image_url' => 'https://images.unsplash.com/photo-1583417319070-4a69db38a482?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'warning',
            'badge_text_ar' => 'وجهة اقتصادية',
            'badge_text_en' => 'Budget Destination',
            'is_popular' => true,
            'best_months' => json_encode(['مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر']),
            'weather_types' => json_encode(['معتدل', 'بارد وثلجي']),
            'trip_types' => json_encode(['مغامرة', 'ثقافية', 'عائلية']),
        ]);

        // Indonesia
        Destination::create([
            'name_ar' => 'إندونيسيا',
            'name_en' => 'Indonesia',
            'description_ar' => 'أرخبيل استوائي ساحر مع شواطئ خلابة وثقافة غنية',
            'description_en' => 'Charming tropical archipelago with stunning beaches and rich culture',
            'currency' => 'الروبية الإندونيسية',
            'exchange_rate' => 4000.0000,
            'min_daily_budget' => 180,
            'max_daily_budget' => 320,
            'image_url' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'info',
            'badge_text_ar' => 'جزر استوائية',
            'badge_text_en' => 'Tropical Islands',
            'is_popular' => false,
            'best_months' => json_encode(['أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر']),
            'weather_types' => json_encode(['دافئ ومشمس', 'استوائي']),
            'trip_types' => json_encode(['استجمام', 'مغامرة', 'رومانسية']),
        ]);

        // Thailand
        Destination::create([
            'name_ar' => 'تايلاند',
            'name_en' => 'Thailand',
            'description_ar' => 'أرض الابتسامات مع معابد ذهبية وشواطئ رملية بيضاء',
            'description_en' => 'Land of smiles with golden temples and white sandy beaches',
            'currency' => 'الباهت التايلاندي',
            'exchange_rate' => 9.8000,
            'min_daily_budget' => 220,
            'max_daily_budget' => 380,
            'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'success',
            'badge_text_ar' => 'متنوعة',
            'badge_text_en' => 'Diverse',
            'is_popular' => false,
            'best_months' => json_encode(['نوفمبر', 'ديسمبر', 'يناير', 'فبراير', 'مارس']),
            'weather_types' => json_encode(['دافئ ومشمس', 'استوائي']),
            'trip_types' => json_encode(['عائلية', 'مغامرة', 'ثقافية', 'استجمام', 'تسوق']),
        ]);

        // UAE
        Destination::create([
            'name_ar' => 'الإمارات العربية المتحدة',
            'name_en' => 'United Arab Emirates',
            'description_ar' => 'وجهة راقية تجمع بين الحداثة والتراث العربي الأصيل',
            'description_en' => 'Luxury destination combining modernity with authentic Arab heritage',
            'currency' => 'الدرهم الإماراتي',
            'exchange_rate' => 0.9800,
            'min_daily_budget' => 400,
            'max_daily_budget' => 800,
            'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'badge_type' => 'primary',
            'badge_text_ar' => 'فاخرة',
            'badge_text_en' => 'Luxury',
            'is_popular' => true,
            'best_months' => json_encode(['أكتوبر', 'نوفمبر', 'ديسمبر', 'يناير', 'فبراير', 'مارس', 'أبريل']),
            'weather_types' => json_encode(['دافئ ومشمس', 'معتدل']),
            'trip_types' => json_encode(['تسوق', 'عائلية', 'رومانسية', 'استجمام']),
        ]);
    }
}
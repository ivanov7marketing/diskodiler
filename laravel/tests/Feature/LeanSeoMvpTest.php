<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CatalogDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeanSeoMvpTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_mvp_pages_are_available(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        foreach ([
            '/',
            '/diski',
            '/diski?brand=BMW',
            '/diski/bmw',
            '/diski/bmw/x5-g05',
            '/diski/bmw/m3-m4-g80-g82',
            '/services',
            '/services/premium-tire-fitting',
            '/services/wheel-restoration',
            '/services/vin-selection',
            '/about.html',
            '/delivery',
            '/warranty',
            '/privacy',
            '/robots.txt',
            '/sitemap.xml',
            '/product/19-style-793-individual-oem-36118089896',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }

        $this->get('/contacts')->assertRedirect('/about.html');
    }

    public function test_services_index_links_to_service_landings(): void
    {
        $this->get('/services')
            ->assertOk()
            ->assertSee('/services/premium-tire-fitting', false)
            ->assertSee('/services/wheel-restoration', false)
            ->assertSee('services_index_fitting', false)
            ->assertSee('services_index_restoration', false)
            ->assertSee('Шиномонтаж, ремонт дисков, trade-in, RunFlat')
            ->assertSee('Премиальный сервис для колес больших диаметров')
            ->assertSee('Премиальный шиномонтаж')
            ->assertSee('Восстановление, ремонт, реставрация')
            ->assertSee('Записаться в сервис')
            ->assertSee('RunFlat')
            ->assertSee('Trade-in')
            ->assertSee('Индивидуальная сборка')
            ->assertSee('проверим посадку перед установкой')
            ->assertDontSee('Что еще делаем с колесами')
            ->assertDontSee('Выкуп колес');
    }

    public function test_home_page_shows_all_active_brands(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('BMW')
            ->assertSee('Mercedes-Benz')
            ->assertSee('Porsche')
            ->assertSee('Range Rover')
            ->assertSee('Lamborghini')
            ->assertSee('Rolls-Royce')
            ->assertSee('RAM')
            ->assertSee('/diski/rolls-royce', false)
            ->assertSee('/diski/ram', false)
            ->assertSee('/diski/bmw/x5-g05', false)
            ->assertSee('/diski/bmw/x3-g01', false)
            ->assertSee('/diski/bmw/3-4-g20', false)
            ->assertSee('/diski/bmw/m3-m4-g80-g82', false)
            ->assertSee('/diski/porsche/cayenne', false)
            ->assertSee('/diski/mercedes-benz/gle-w167', false)
            ->assertSee('/diski/range-rover/sport', false)
            ->assertSee('/services/premium-tire-fitting', false)
            ->assertSee('/services/wheel-restoration', false)
            ->assertSee('home_service_fitting', false)
            ->assertSee('home_service_restoration', false)
            ->assertSee('Шиномонтаж и реставрация')
            ->assertDontSee('home_service_vin', false)
            ->assertSee('value="Max"', false)
            ->assertSee('data-quiz-phone', false)
            ->assertSee('quiz-contact-fields', false)
            ->assertDontSee('quiz-telegram', false)
            ->assertDontSee('name="telegram"', false)
            ->assertDontSee('/diski?brand=BMW&amp;model=X5%20G05', false)
            ->assertDontSee('/diski?brand=Porsche&amp;model=Cayenne', false);

        $sharedJs = file_get_contents(public_path('assets/js/app.js'));

        $this->assertStringContainsString('{ page: "delivery", label: "Доставка", href: "delivery/" }', $sharedJs);
        $this->assertStringContainsString('{ page: "about", label: "О компании", href: "about.html" }', $sharedJs);
        $this->assertStringContainsString('Уточним время и размер', $sharedJs);
        $this->assertStringContainsString('<option value="Max">Max</option>', $sharedJs);
        $this->assertStringNotContainsString('{ page: "contacts", label: "Контакты"', $sharedJs);
    }

    public function test_delivery_page_contains_shipping_payment_and_old_site_logistics_details(): void
    {
        $this->get('/delivery')
            ->assertOk()
            ->assertSee('Доставка и оплата оригинальных дисков')
            ->assertSee('Россия и СНГ')
            ->assertSee('Деловые Линии')
            ->assertSee('Фото/видео фиксация')
            ->assertSee('Самовывоз в Санкт-Петербурге')
            ->assertSee('Оплата комплекта и перевозки')
            ->assertSee('Салова 27АД')
            ->assertSee('Салова 31с3')
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"@type":"BreadcrumbList"', false);
    }

    public function test_catalog_is_rendered_from_database_and_filters_products(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $this->get('/diski')
            ->assertOk()
            ->assertSee('Оригинальные диски купить в Санкт-Петербурге')
            ->assertSee('Каталог оригинальных дисков')
            ->assertSee('20&quot; Double Spoke 699 Jet Black', false)
            ->assertSee('23&quot; Range Rover Style 1075', false)
            ->assertSee('Lamborghini')
            ->assertSee('Rolls-Royce')
            ->assertSee('RAM')
            ->assertDontSee('Оригинальные диски BMW X5 G05')
            ->assertDontSee('data-products-grid', false);

        $this->get('/diski?brand=BMW&model=X5%20G05')
            ->assertOk()
            ->assertSee('20&quot; Double Spoke 699 Jet Black', false)
            ->assertDontSee('23&quot; Range Rover Style 1075', false);
    }

    public function test_brand_page_contains_seo_support_blocks(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $this->get('/diski/porsche')
            ->assertOk()
            ->assertSee('Страницы под конкретный кузов')
            ->assertSee('Что подбираем для Porsche')
            ->assertSee('диски Porsche Cayenne')
            ->assertSee('Санкт-Петербург и доставка')
            ->assertSee('Что проверяем перед продажей')
            ->assertSee('Частые вопросы про диски Porsche')
            ->assertSee('BreadcrumbList')
            ->assertSee('/diski/porsche/cayenne', false);
    }

    public function test_brand_pages_have_unique_yandex_oriented_seo_copy(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $expectations = [
            '/diski/bmw' => ['Оригинальные диски BMW купить в СПб', 'диски BMW G05', 'R17-R22'],
            '/diski/mercedes-benz' => ['Оригинальные диски Mercedes-Benz купить', 'диски Mercedes AMG', 'GLE, GLC, GLB'],
            '/diski/porsche' => ['Оригинальные диски Porsche купить в СПб', 'диски Porsche Macan', 'Cayenne, Macan, Panamera'],
            '/diski/range-rover' => ['Оригинальные диски Range Rover купить', 'диски Range Rover Sport', 'R19-R23'],
            '/diski/lamborghini' => ['Оригинальные диски Lamborghini купить', 'диски Lamborghini Urus', 'Gallardo'],
            '/diski/rolls-royce' => ['Оригинальные диски Rolls-Royce купить', 'диски Rolls-Royce Cullinan', 'редкими комплектами'],
            '/diski/ram' => ['Оригинальные диски RAM купить под заказ', 'диски RAM 1500', 'допустимая нагрузка'],
        ];

        foreach ($expectations as $uri => $terms) {
            $response = $this->get($uri)->assertOk();

            foreach ($terms as $term) {
                $response->assertSee($term);
            }
        }
    }

    public function test_catalog_and_product_return_404_for_invalid_slugs(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $this->get('/product/not-a-real-product')->assertNotFound();
        $this->get('/diski/bmw/cayenne')->assertNotFound();
    }

    public function test_service_pages_are_selling_landings_with_faq_schema(): void
    {
        foreach ([
            '/services/vin-selection' => 'VIN selection',
            '/services/wheel-restoration' => 'Wheel restoration',
            '/services/premium-tire-fitting' => 'RunFlat service',
        ] as $uri => $kicker) {
            $this->get($uri)
                ->assertOk()
                ->assertSee('data-service-landing', false)
                ->assertSee($kicker)
                ->assertSee('service-trust-grid', false)
                ->assertSee('service-cases-grid', false)
                ->assertSee('<div class="faq">', false)
                ->assertSee('"@type":"FAQPage"', false)
                ->assertSee('"@type":"BreadcrumbList"', false);
        }
    }

    public function test_faq_json_ld_is_rendered_on_key_landing_pages(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        foreach ([
            '/diski',
            '/diski/bmw',
            '/diski/bmw/x5-g05',
            '/product/19-style-793-individual-oem-36118089896',
            '/services/vin-selection',
            '/services/wheel-restoration',
            '/services/premium-tire-fitting',
        ] as $uri) {
            $this->get($uri)
                ->assertOk()
                ->assertSee('"@type":"FAQPage"', false)
                ->assertSee('"mainEntity"', false);
        }
    }

    public function test_product_page_uses_product_seo_json_ld_uploaded_media_and_internal_links(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $product = Product::where('slug', '19-style-793-individual-oem-36118089896')->firstOrFail();
        $product->update([
            'meta_title' => 'SEO title for product test',
            'meta_description' => 'SEO description for product test',
            'h1' => 'Custom product H1',
            'seo_text' => 'Тестовый SEO-текст товара про проверку OEM и совместимость по VIN.',
            'stock_status' => 'reserved',
            'set_condition' => 'used_good',
            'diameter' => 'R19',
            'width_front' => '8.0J',
            'width_rear' => '8.5J',
            'et_front' => '27',
            'et_rear' => '40',
            'pcd' => '5x112',
            'dia' => '66.6',
        ]);
        $product->images()->create([
            'path' => 'products/images/test-wheel.jpg',
            'disk' => 'public',
            'alt' => 'Uploaded wheel image',
            'sort' => 1,
            'is_primary' => true,
        ]);

        $this->get('/product/19-style-793-individual-oem-36118089896')
            ->assertOk()
            ->assertSee('SEO title for product test')
            ->assertSee('SEO description for product test')
            ->assertSee('Custom product H1')
            ->assertSee('Забронировать')
            ->assertSee('Уточнить детали')
            ->assertSee('product-reserve-modal', false)
            ->assertSee('product-details-modal', false)
            ->assertSee('Условия покупки')
            ->assertSee('Доставка')
            ->assertSee('Гарантия')
            ->assertSee('Возврат')
            ->assertSee('Оригинальность')
            ->assertSee('Помощь по VIN')
            ->assertSee('Доставка по России')
            ->assertSee('Самовывоз и осмотр')
            ->assertSee('Состояние комплекта')
            ->assertSee('Параметры комплекта')
            ->assertSee('Характеристики дисков BMW 3/4 G20')
            ->assertSee('Статус наличия')
            ->assertSee('В резерве')
            ->assertSee('Тестовый SEO-текст товара про проверку OEM')
            ->assertSee('Полезные разделы')
            ->assertSee('Похожие диски для BMW 3/4 G20')
            ->assertSee('Все диски для 3/4 G20')
            ->assertSee('Написать в Telegram')
            ->assertSee('Написать в Max')
            ->assertSee('Написать в WhatsApp')
            ->assertSee('/assets/img/messengers/icon-telegram.png', false)
            ->assertSee('/assets/img/messengers/icon-max.png', false)
            ->assertSee('/assets/img/messengers/icon-whatsapp.png', false)
            ->assertSee('"@type":"Product"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('"category":"Автомобильные диски"', false)
            ->assertSee('"additionalProperty"', false)
            ->assertSee('"name":"PCD"', false)
            ->assertSee('"value":"5x112"', false)
            ->assertSee('"availability":"https://schema.org/LimitedAvailability"', false)
            ->assertSee('/storage/products/images/test-wheel.jpg', false)
            ->assertSee('images.unsplash.com/photo-1542362567-b07e54358753', false)
            ->assertSee('Uploaded wheel image')
            ->assertSee('/diski/bmw/3-4-g20', false)
            ->assertSee('/diski/bmw', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('R19')
            ->assertSee('8.0J')
            ->assertSee('8.5J')
            ->assertSee('27')
            ->assertSee('40')
            ->assertSee('5x112')
            ->assertSee('66.6')
            ->assertSee('product-faq', false)
            ->assertSee('Б/у, хорошее состояние')
            ->assertDontSee('Расчет доплаты');
    }

    public function test_product_gallery_renders_multiple_square_ready_images(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        Product::query()
            ->active()
            ->withCount('images')
            ->get()
            ->each(fn (Product $product) => $this->assertSame(4, $product->images_count, $product->slug));

        $this->get('/product/20-double-spoke-699-jet-black-oem-36118089896')
            ->assertOk()
            ->assertSee('data-gallery-main', false)
            ->assertSee('data-gallery-thumb', false)
            ->assertSee('data-gallery-next', false)
            ->assertSee('20&quot; Double Spoke 699 Jet Black фото 4', false);
    }

    public function test_dynamic_sitemap_contains_catalog_landing_pages_and_products(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('content-type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee('/diski/bmw', false)
            ->assertSee('/diski/bmw/x5-g05', false)
            ->assertSee('/services/vin-selection', false)
            ->assertSee('/services/wheel-restoration', false)
            ->assertSee('/services/premium-tire-fitting', false)
            ->assertSee('/product/19-style-793-individual-oem-36118089896', false)
            ->assertSee('<priority>0.7</priority>', false)
            ->assertDontSee('/contacts', false);
    }

    public function test_robots_points_to_dynamic_sitemap_and_blocks_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('content-type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /admin')
            ->assertSee('/sitemap.xml');
    }

    public function test_test_domain_can_be_globally_closed_from_indexing(): void
    {
        config()->set('app.prevent_indexing', true);

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('content-type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /')
            ->assertDontSee('Allow: /', false)
            ->assertDontSee('/sitemap.xml', false);
    }

    public function test_lead_can_be_saved(): void
    {
        $response = $this->postJson('/leads', [
            'type' => 'vin_selection',
            'goal' => 'test_goal',
            'page' => '/services/vin-selection',
            'fields' => [
                'name' => 'Максим',
                'phone' => '+7 999 000-00-00',
                'vin' => 'WBA1234567890',
                'message' => 'Проверить комплект',
            ],
            'utm' => [
                'utm_source' => 'test',
            ],
        ]);

        $response->assertCreated()->assertJson(['ok' => true]);

        $this->assertDatabaseHas(Lead::class, [
            'type' => 'vin_selection',
            'phone' => '+7 999 000-00-00',
            'vin' => 'WBA1234567890',
            'source_page' => '/services/vin-selection',
        ]);
    }

    public function test_filament_admin_requires_login_and_allows_admin_user(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->get('/admin')->assertRedirect('/admin/login');

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk();
    }

    public function test_filament_resource_pages_render_without_intl_extension(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        foreach ([
            '/admin/brands',
            '/admin/vehicle-models',
            '/admin/products',
            '/admin/leads',
        ] as $uri) {
            $this->actingAs($user)->get($uri)->assertOk();
        }
    }

    public function test_filament_product_form_sections_and_manager_filters_render(): void
    {
        $this->seed(CatalogDemoSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->actingAs($user)
            ->get('/admin/products/create')
            ->assertOk()
            ->assertSee('Основное')
            ->assertSee('Цена и наличие')
            ->assertSee('Параметры дисков')
            ->assertSee('Медиа')
            ->assertSee('SEO и описание')
            ->assertSee('Фото лучше загружать квадратом 1:1')
            ->assertSee('Alt')
            ->assertSee('SEO title')
            ->assertSee('SEO description');

        $this->actingAs($user)
            ->get('/admin/products')
            ->assertOk()
            ->assertSee('Фото')
            ->assertSee('Статус')
            ->assertSee('Состояние')
            ->assertSee('Без фото')
            ->assertSee('Без цены')
            ->assertSee('Без OEM')
            ->assertSee('Без SEO title/description')
            ->assertSee('Без видео')
            ->assertSee('С видео');
    }

    public function test_lead_saves_contact_method_for_manager_workflow(): void
    {
        $response = $this->postJson('/leads', [
            'type' => 'wheel_quiz',
            'goal' => 'wheel_quiz_submit',
            'page' => '/',
            'fields' => [
                'name' => 'Максим',
                'phone' => '+7 (999) 000-00-00',
                'contactMethod' => 'Max',
                'message' => 'Нужен комплект на BMW X5 G05',
            ],
        ]);

        $response->assertCreated()->assertJson(['ok' => true]);

        $this->assertDatabaseHas(Lead::class, [
            'type' => 'wheel_quiz',
            'phone' => '+7 (999) 000-00-00',
            'contact_method' => 'Max',
            'source_page' => '/',
        ]);

        $lead = Lead::where('phone', '+7 (999) 000-00-00')->firstOrFail();

        $this->assertSame('Max', $lead->payload['contactMethod']);
    }

    public function test_filament_leads_manager_workflow_renders(): void
    {
        $lead = Lead::create([
            'type' => 'wheel_quiz',
            'status' => 'new',
            'name' => 'Максим',
            'phone' => '+7 (999) 000-00-00',
            'contact_method' => 'Max',
            'vin' => 'WBA1234567890',
            'message' => 'Нужен комплект на BMW X5 G05',
            'manager_comment' => 'Проверить наличие и отправить подборку',
            'source_page' => '/',
            'goal' => 'wheel_quiz_submit',
            'payload' => [
                'brand' => 'BMW',
                'model' => 'X5 G05',
                'contactMethod' => 'Max',
            ],
        ]);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->actingAs($user)
            ->get('/admin/leads')
            ->assertOk()
            ->assertSee('Новая')
            ->assertSee('Квиз')
            ->assertSee('Максим')
            ->assertSee('Max')
            ->assertSee('В работу')
            ->assertSee('Связались')
            ->assertSee('Не дозвонились')
            ->assertSee('Закрыть')
            ->assertSee('Без телефона')
            ->assertSee('С VIN')
            ->assertSee('Не обработаны');

        $this->actingAs($user)
            ->get("/admin/leads/{$lead->id}/edit")
            ->assertOk()
            ->assertSee('Статус обработки')
            ->assertSee('Контакт клиента')
            ->assertSee('Источник')
            ->assertSee('Технические данные')
            ->assertSee('Комментарий менеджера')
            ->assertSee('Удобный способ связи');
    }
}

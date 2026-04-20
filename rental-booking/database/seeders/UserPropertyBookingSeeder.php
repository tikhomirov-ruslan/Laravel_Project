<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserPropertyBookingSeeder extends Seeder
{
    public function run(): void
    {
        $guest = User::query()->updateOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'Алия Сейтова', 'password' => 'password', 'role' => 'customer']
        );

        $secondGuest = User::query()->updateOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'Нурсултан Беков', 'password' => 'password', 'role' => 'customer']
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@example.com'],
            ['name' => 'Ермек Тулеуов', 'password' => 'password', 'role' => 'owner']
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Администратор', 'password' => 'password', 'role' => 'admin']
        );

        $apartment = Category::query()->where('slug', 'apartment')->first();
        $apartments = Category::query()->where('slug', 'apartments')->first();
        $studio = Category::query()->where('slug', 'studio')->first();
        $loft = Category::query()->where('slug', 'loft')->first();

        $propertiesData = [
            [
                'title' => 'Уютная квартира у Арбата',
                'description' => 'Светлая квартира в центре Алматы. Рядом Арбат, метро и кафе. Подходит для пары или деловой поездки.',
                'address' => 'ул. Панфилова, 105, Алматы',
                'price_per_night' => 24000,
                'max_guests' => 2,
                'category_id' => $apartment?->id,
                'amenities' => ['Wi-Fi', 'Кухня', 'Стиральная машина', 'Смарт ТВ'],
            ],
            [
                'title' => 'Апартаменты с видом на Кок-Тобе',
                'description' => 'Современные апартаменты с просторной гостиной и красивым видом на город. Идеально для отдыха семьи.',
                'address' => 'пр. Достык, 172, Алматы',
                'price_per_night' => 38000,
                'max_guests' => 4,
                'category_id' => $apartments?->id,
                'amenities' => ['Wi-Fi', 'Парковка', 'Кондиционер', 'Вид на горы', 'Балкон'],
            ],
            [
                'title' => 'Студия рядом с Mega Center',
                'description' => 'Компактная и удобная студия для одного или двух гостей. Удобный выезд на Аль-Фараби.',
                'address' => 'ул. Розыбакиева, 247а, Алматы',
                'price_per_night' => 21000,
                'max_guests' => 2,
                'category_id' => $studio?->id,
                'amenities' => ['Wi-Fi', 'Кухня', 'Рабочее место', 'Кондиционер'],
            ],
            [
                'title' => 'Лофт в районе Золотого квадрата',
                'description' => 'Стильный лофт с высокими потолками, удобной спальней и рабочей зоной. Хороший вариант для туристов и фрилансеров.',
                'address' => 'ул. Кабанбай батыра, 83, Алматы',
                'price_per_night' => 32000,
                'max_guests' => 3,
                'category_id' => $loft?->id,
                'amenities' => ['Wi-Fi', 'Рабочее место', 'Смарт ТВ', 'Бесконтактное заселение'],
            ],
            [
                'title' => 'Семейная квартира возле Esentai',
                'description' => 'Просторная квартира с двумя спальнями и кухней. Подходит для семьи с детьми или гостей на несколько дней.',
                'address' => 'ул. Сатпаева, 30/8, Алматы',
                'price_per_night' => 41000,
                'max_guests' => 5,
                'category_id' => $apartment?->id,
                'amenities' => ['Wi-Fi', 'Кухня', 'Парковка', 'Стиральная машина', 'Балкон'],
            ],
            [
                'title' => 'Апартаменты у гор с тихим двором',
                'description' => 'Тихий район, свежий воздух и удобная транспортная доступность. Отлично подойдёт для спокойного отдыха.',
                'address' => 'мкр. Самал-2, 58, Алматы',
                'price_per_night' => 29000,
                'max_guests' => 3,
                'category_id' => $apartments?->id,
                'amenities' => ['Wi-Fi', 'Вид на горы', 'Парковка', 'Кондиционер'],
            ],
        ];

        foreach ($propertiesData as $propertyData) {
            $amenityNames = $propertyData['amenities'];
            unset($propertyData['amenities']);

            $property = Property::query()->updateOrCreate(
                ['title' => $propertyData['title']],
                array_merge($propertyData, ['user_id' => $owner->id]),
            );

            $amenityIds = Amenity::query()
                ->whereIn('name', $amenityNames)
                ->pluck('id');

            $property->amenities()->sync($amenityIds);
        }

        $firstProperty = Property::query()->where('title', 'Уютная квартира у Арбата')->first();
        $secondProperty = Property::query()->where('title', 'Апартаменты с видом на Кок-Тобе')->first();
        $thirdProperty = Property::query()->where('title', 'Студия рядом с Mega Center')->first();

        if ($firstProperty) {
            $pastBooking = Booking::query()->updateOrCreate(
                [
                    'user_id' => $guest->id,
                    'property_id' => $firstProperty->id,
                    'start_date' => now()->subDays(12)->toDateString(),
                ],
                [
                    'end_date' => now()->subDays(9)->toDateString(),
                    'total_price' => $firstProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );

            Review::query()->updateOrCreate(
                ['booking_id' => $pastBooking->id],
                [
                    'user_id' => $guest->id,
                    'property_id' => $firstProperty->id,
                    'rating' => 5,
                    'comment' => 'Очень удобное расположение, чисто и тихо. Заселение прошло быстро.',
                ]
            );
        }

        if ($secondProperty) {
            Booking::query()->updateOrCreate(
                [
                    'user_id' => $secondGuest->id,
                    'property_id' => $secondProperty->id,
                    'start_date' => now()->addDays(6)->toDateString(),
                ],
                [
                    'end_date' => now()->addDays(9)->toDateString(),
                    'total_price' => $secondProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );
        }

        if ($thirdProperty) {
            Booking::query()->updateOrCreate(
                [
                    'user_id' => $guest->id,
                    'property_id' => $thirdProperty->id,
                    'start_date' => now()->addDays(14)->toDateString(),
                ],
                [
                    'end_date' => now()->addDays(17)->toDateString(),
                    'total_price' => $thirdProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // products table
        DB::table('products')->insert([
            'product_name' => 'Acetylcystein 200 Imexpharm',
            'product_description' => 'Dùng làm thuốc tiêu chất nhầy trong bệnh nhầy nhớt (mucoviscidosis) như xơ nang tuyến tụy, bệnh lý đường hô hấp có đờm nhầy quánh như trong viêm phế quản cấp và mạn tính, làm sạch thường quy trong mở khí quản.',
            'product_image' => 'https://cdn.nhathuoclongchau.com.vn/unsafe/https://cms-prod.s3-sgn09.fptcloud.com/IMG_1309_9bba6ffb56.jpg',
            'brands' => 'Imexpharm',
            'quantity' => 100,
            'tax' => 10,
            'price_box_listing' => 147000,
            'price_box_discounted' => 147000,
            'price_item_listing' => 15000,
            'price_item_discounted' => 15000,
            'limit_by_age' => 2,
            'limit_per_order' => 3,
            'ingredients' => "Mannitol, Aspartam, Colloidal anhydrous silica",
            'SKU' => '248834',
            'barcode' => "8850127003819",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Telfast BD 60mg',
            'product_description' => 'Telfast BD 60mg 30 viên được chỉ định để điều trị viêm mũi dị ứng theo mùa và mày đay vô căn mạn tính ở người lớn và trẻ em từ 12 tuổi trở lên.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/10036/292598/telfast-bd-60mg-mac-dinh-2.jpg',
            'brands' => 'Sanofi',
            'quantity' => 100,
            'tax' => 7,
            'price_box_listing' => 114000,
            'price_box_discounted' => 114000,
            'price_item_listing' => 3800,
            'price_item_discounted' => 3800,
            'limit_by_age' => 12,
            'limit_per_order' => 3,
            'ingredients' => "Fexofenadin, microcrystalline cellulose (avicel pH 101, avicel pH 102), pregelatinised maize starch, croscarmellose natri, magnesi stearat, hypromellose E-5, hypromellose E-15, titan dioxyd, povidon, colloidal anhydrous silica, macrogol 400, hỗn hợp pink iron oxyd (PB1254), hỗn hợp yellow iron oxyd (PB1255)",
            'SKU' => '292598',
            'barcode' => "8850127003820",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Dung dịch uống Atilene 2.5mg/5ml',
            'product_description' => 'Trị triệu chứng dị ứng: hô hấp (viêm mũi, hắt hơi, sổ mũi), ngoài da (mề đay, ngứa).',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/10036/305964/atilene-5ml-mac-dinh-2.jpg',
            'brands' => 'An Thiên Pharma',
            'quantity' => 100,
            'tax' => 5,
            'price_box_listing' => 70000,
            'price_box_discounted' => 70000,
            'price_item_listing' => 2500,
            'price_item_discounted' => 2500,
            'limit_by_age' => 2,
            'limit_per_order' => 3,
            'ingredients' => "Sucrose, Natri carboxymethylcellulose, Acid citric, Sorbitol 70%, Methyl paraben, Propyl paraben, Propylen glycol, Màu sunset yellow, Hương cam, Nước tinh khiết",
            'SKU' => '305964',
            'barcode' => "8850127003821",
        ]);

        DB::table('products')->insert([
            'product_name' => 'IsoPharco Ginkgo Q10',
            'product_description' => 'Tăng cường tuần hoàn não, giảm triệu chứng thiểu năng tuần hoàn não.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/6985/230748/ginkgo-q10-iso-h-100v-hinh-2.jpg',
            'brands' => 'IsoPharco',
            'quantity' => 100,
            'tax' => 7,
            'price_box_listing' => 58000,
            'price_box_discounted' => 58000,
            'price_item_listing' => 5800,
            'price_item_discounted' => 5800,
            'limit_by_age' => 12,
            'limit_per_order' => 3,
            'ingredients' => "Ginkgo biloba extract (Cao khô Bạch quả), Đinh lăng, Magnesi oxyd, Bột tỏi, Vitamin B1, Vitamin B2 (Riboflavin), Vitamin B6 (pyridoxin hydroclorid), Citicolin sodium, Coenzym Q10.",
            'SKU' => '230748',
            'barcode' => "8850127003822",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Đại tràng Tâm Bình',
            'product_description' => 'Giảm triệu chứng viêm đại tràng co thắt, hỗ trợ kích thích tiêu hóa.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/11419/128992/vien-uong-dai-trang-tam-binh-60-vien-0.jpg',
            'brands' => 'Tâm Bình',
            'quantity' => 100,
            'tax' => 10,
            'price_box_listing' => 89000,
            'price_box_discounted' => 89000,
            'price_item_listing' => 1500,
            'price_item_discounted' => 1500,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Bạch truật, Bạch Linh, Đảng sâm, Trần bì, Mộc hương bắc, Hoài sơn, Nhục đậu khấu, Mạch nha, Cam thảo, Bột Sơn tra, Bột sa nhân, Bột Hoàng liên.",
            'SKU' => '128992',
            'barcode' => "8850127003823",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Men vi sinh LiveSpo Clausy',
            'product_description' => 'Bổ sung lợi khuẩn, giảm triệu chứng và nguy cơ rối loạn tiêu hóa.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/10253/294003/men-vi-sinh-livespo-clausy-giup-can-bang-he-vi-sinh-duong-ruot-mac-dinh-2.jpg',
            'brands' => 'LiveSpo Pharma',
            'quantity' => 100,
            'tax' => 8,
            'price_box_listing' => 128000,
            'price_box_discounted' => 128000,
            'price_item_listing' => 6400,
            'price_item_discounted' => 6400,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Mỗi ống có chứa 2 tỷ (2x109) bào tử lợi khuẩn Bacillus clausii và nước cất vừa đủ 5mL",
            'SKU' => '294003',
            'barcode' => "8850127003824",
        ]);

        DB::table('products')->insert([
            'product_name' => 'EDK500',
            'product_description' => 'Bổ sung vitamin E, tăng cường chống oxy hóa, hạn chế lão hóa, làm đẹp da.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/7004/243299/edk500-h-30v-mac-dinh-2.jpg',
            'brands' => 'Dân Khang',
            'quantity' => 100,
            'tax' => 10,
            'price_box_listing' => 166000,
            'price_box_discounted' => 166000,
            'price_item_listing' => 5600,
            'price_item_discounted' => 5600,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Vitamin E tự nhiên (Natural source D-alpha-tocopheryl acetate oil), Dầu Olive, Dầu Gấc, tinh dầu Hạt Nho. Phụ liệu: Gelatin, Glycerin, Sorbitol, Nipazin, Ethyl vanilint",
            'SKU' => '243299',
            'barcode' => "8850127003825",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Dung dịch Cvincep Nấm Đông Trùng Hạ Thảo',
            'product_description' => 'Tăng cường sức khoẻ, giúp ăn ngủ ngon, tăng cường thể lực.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/10262/269502/cvincep-h-20-ong-mac-dinh-2.jpg',
            'brands' => 'Cvin',
            'quantity' => 100,
            'tax' => 10,
            'price_box_listing' => 330000,
            'price_box_discounted' => 330000,
            'price_item_listing' => 16500,
            'price_item_discounted' => 16500,
            'limit_by_age' => 5,
            'limit_per_order' => 3,
            'ingredients' => "Cordyceps militaris extract, Cao Đảng sâm(Codonopsis javanica extract), Cao Vông nem (Erythrina variegata extract), Cao Tam thất (Panax Pseudo ginseng extract), Cao linh chi (Ganoderma lucidum extract), Cao Đinh lăng (Polycias fructicosa extract), Cao Đương quy (Angelica sinensis extract), Cao Đan Sâm (Salvia miltiorrhiza extract), Cao Cỏ ngọt (Stevia rebaudiana extract), Vitamin B1(Thiamin hydroclorid).",
            'SKU' => '269502',
            'barcode' => "8850127003826",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Nattospes',
            'product_description' => 'Phòng ngừa và phá được các cục máu đông, tăng tuần hoàn và lưu thông máu.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/11339/131461/nattospes-30v-1.jpg',
            'brands' => 'Y Dược Quốc Tế IMC',
            'quantity' => 100,
            'tax' => 9,
            'price_box_listing' => 160000,
            'price_box_discounted' => 160000,
            'price_item_listing' => 5400,
            'price_item_discounted' => 5400,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Nattokinase",
            'SKU' => '131461',
            'barcode' => "8850127003827",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Doppelherz Coenzyme Q10',
            'product_description' => 'Cung cấp Coenzyme Q10 và vitamin hỗ trợ sức khỏe tim mạch, giảm mệt mỏi.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/11339/230098/doppelherz-aktiv-coenzyme-q10-h-30v-mac-dinh-2.jpg',
            'brands' => 'Doppelherz',
            'quantity' => 100,
            'tax' => 10,
            'price_box_listing' => 166000,
            'price_box_discounted' => 166000,
            'price_item_listing' => 5600,
            'price_item_discounted' => 5600,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Coenzyme Q10 , Chiết xuất sơn tra, Vitamin B1, Vitamin B6, Vitamin B12.",
            'SKU' => '230098',
            'barcode' => "8850127003828",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Diabetna',
            'product_description' => 'Hỗ trợ ổn định đường huyết cho người bị tiểu đường tuýp 1 và tuýp 2.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/11338/131093/diabetna-40v-1.jpg',
            'brands' => 'Nam Dược',
            'quantity' => 100,
            'tax' => 5,
            'price_box_listing' => 108000,
            'price_box_discounted' => 108000,
            'price_item_listing' => 2700,
            'price_item_discounted' => 2700,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Cao lá Dây thìa canh (Gymnema sylvestre), Tá dược: Amidon, aerosil, PEG 6000, tween 80, talc, magnesi stearat, kali sorbat",
            'SKU' => '131093',
            'barcode' => "8850127003829",
        ]);

        DB::table('products')->insert([
            'product_name' => 'Tumolung',
            'product_description' => 'Tăng cường chống oxy hóa, hỗ trợ giảm nguy cơ viêm nhiễm.',
            'product_image' => 'https://cdn.tgdd.vn/Products/Images/11798/211603/tumolung-hop-30vien-2.jpg',
            'brands' => 'Y Dược Quốc Tế IMC',
            'quantity' => 100,
            'tax' => 8,
            'price_box_listing' => 450000,
            'price_box_discounted' => 450000,
            'price_item_listing' => 15000,
            'price_item_discounted' => 15000,
            'limit_by_age' => 0,
            'limit_per_order' => 3,
            'ingredients' => "Lunatumo; Cao Hoàng kỳ 120mg; Cao Bán chi liên; Cao Bồ công anh; Cao Cọ xẻ (Quy tô tử); Cao Quả khế; Cao Mạch chủ (Candied jujube)",
            'SKU' => '211603',
            'barcode' => "8850127003830",
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@vhz.io',
            'password' => bcrypt('28062806'),
            'role_id' => 'user_admin'
        ]);

        DB::table('users')->insert([
            'name' => 'cashier1',
            'email' => 'cashier1@vhz.io',
            'password' => bcrypt('28062806'),
            'role_id' => 'user_cashier',
            'employee_id' => 'cashier1',
            'national_id' => '001200696969',
        ]);

        DB::table('users')->insert([
            'name' => 'cashier2',
            'email' => 'cashier2@vhz.io',
            'password' => bcrypt('28062806'),
            'role_id' => 'user_cashier',
            'employee_id' => 'cashier1',
            'national_id' => '001200696969',
        ]);
    }
}

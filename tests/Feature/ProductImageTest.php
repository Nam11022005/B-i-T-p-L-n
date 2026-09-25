<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_image_and_it_is_shown_on_homepage(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Điện tử']);

        $tempFile = tempnam(sys_get_temp_dir(), 'product-image');
        file_put_contents($tempFile, $this->minimalPngData());

        $uploadedFile = new UploadedFile(
            $tempFile,
            'laptop.png',
            'image/png',
            null,
            true
        );

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Laptop ảnh',
            'description' => 'Sản phẩm có ảnh minh họa',
            'quantity' => 5,
            'price' => 25000000,
            'category_id' => $category->id,
            'unit' => 'kg',
            'min_quantity' => 1,
            'quantity_step' => 1,
            'image' => $uploadedFile,
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::first();
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);

        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('/storage/', false);
    }

    private function minimalPngData(): string
    {
        $ihdrData = pack('NNCCCCC', 1, 1, 8, 6, 0, 0, 0);
        $scanline = "\x00" . pack('C', 255) . pack('C', 0) . pack('C', 0) . pack('C', 255);
        $compressed = gzcompress($scanline, 9);

        $chunkIhdr = pack('N', 13) . 'IHDR' . $ihdrData . pack('N', crc32('IHDR' . $ihdrData) & 0xffffffff);
        $chunkIdat = pack('N', strlen($compressed)) . 'IDAT' . $compressed . pack('N', crc32('IDAT' . $compressed) & 0xffffffff);
        $chunkIend = pack('N', 0) . 'IEND' . pack('N', crc32('IEND') & 0xffffffff);

        return "\x89PNG\r\n\x1a\n" . $chunkIhdr . $chunkIdat . $chunkIend;
    }
}

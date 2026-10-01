<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getIconAttribute(): string
    {
        $name = mb_strtolower(
            trim($this->name ?? ''),
            'UTF-8'
        );

        $rules = [
            [
                'keywords' => [
                    'thịt',
                    'gác bếp',
                    'đồ tươi',
                    'tươi sống',
                ],
                'icon' => '🥩',
            ],
            [
                'keywords' => [
                    'lạp xưởng',
                    'xúc xích',
                ],
                'icon' => '🌭',
            ],
            [
                'keywords' => [
                    'cá',
                    'thủy sản',
                ],
                'icon' => '🐟',
            ],
            [
                'keywords' => [
                    'gia vị',
                    'mắc khén',
                    'hạt dổi',
                    'chẩm chéo',
                    'ớt',
                    'tiêu',
                ],
                'icon' => '🌶️',
            ],
            [
                'keywords' => [
                    'trà',
                    'shan tuyết',
                    'thảo mộc',
                ],
                'icon' => '🍵',
            ],
            [
                'keywords' => [
                    'mật ong',
                    'mật',
                ],
                'icon' => '🍯',
            ],
            [
                'keywords' => [
                    'gạo',
                    'nếp',
                    'ngũ cốc',
                    'lúa',
                ],
                'icon' => '🌾',
            ],
            [
                'keywords' => [
                    'đồ khô',
                    'khô',
                    'sấy',
                ],
                'icon' => '🧺',
            ],
            [
                'keywords' => [
                    'rau',
                    'củ',
                    'nông sản',
                ],
                'icon' => '🥬',
            ],
            [
                'keywords' => [
                    'hoa quả',
                    'trái cây',
                ],
                'icon' => '🍎',
            ],
            [
                'keywords' => [
                    'rượu',
                    'đồ uống',
                ],
                'icon' => '🍶',
            ],
            [
                'keywords' => [
                    'bánh',
                    'kẹo',
                    'ăn vặt',
                ],
                'icon' => '🍘',
            ],
            [
                'keywords' => [
                    'quà',
                    'lưu niệm',
                ],
                'icon' => '🎁',
            ],
            [
                'keywords' => [
                    'thổ cẩm',
                    'vải',
                    'dệt',
                ],
                'icon' => '🧣',
            ],
            [
                'keywords' => [
                    'nấm',
                ],
                'icon' => '🍄',
            ],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['keywords'] as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $rule['icon'];
                }
            }
        }

        $fallback = [
            '🌿',
            '🏔️',
            '🌾',
            '🧺',
            '🍃',
            '🌱',
            '⛰️',
        ];

        if ($name === '') {
            return '🌿';
        }

        $hash = (int) sprintf(
            '%u',
            crc32($name)
        );

        return $fallback[
            $hash % count($fallback)
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
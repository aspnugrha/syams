<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'type',
        'category_id',
        'slug',
        'name',
        'description',
        'cover',
        'image',
        'size_qty_options',
        'material_color_options',
        'sablon_type',
        'is_bordir',
        'active',
        'main_product',
        'bordir',
        'input_settings',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function hasCategory(){
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public static function loadData($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $get_data = Products::orderBy('main_product', 'desc')->orderBy('created_at', 'DESC')
                ->when(request()->search['value'], function ($query) {
                    $query->where('name', 'like', '%' . request()->search['value'] . '%');
                    $query->orWhere('description', 'like', '%' . request()->search['value'] . '%');
                })
                ->when(request()->category_id != null, function ($query) {
                    $query->where('category_id', request()->category_id);
                })
                ->when(request()->type != null, function ($query) {
                    $query->where('type', request()->type);
                })
                ->when(request()->active != null, function ($query) {
                    $query->where('active', request()->active);
                })
                ->when(request()->created_at != null, function ($query) {
                    $created_ranges = explode(' - ', request()->created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                });

            $data = [
                'recordsTotal' => $get_data->count(),
                'recordsFiltered' => $get_data->count(),
                'data' => $get_data->skip($request->input('start'))->take($request->input('length'))->get()
            ];

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    
    public static function getDataMaterials($filter_name = null){
        $data = [
            [
                'name' => 'Baby Terry Cotton (220gsm)',
                'desc' => "With a predominant cotton fiber content, the fabric has a soft, smooth feel and is very comfortable to wear as warm clothing. This fabric's distinctive feature is its small loops.",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                ],
            ],
            [
                'name' => 'Baby Terry CVC (255gsm)',
                'desc' => "With a predominant cotton fiber content, the fabric has a soft, smooth feel and is very comfortable to wear as warm clothing. This fabric's distinctive feature is its small loops.",
                'colors' => [
                    [
                        'color' => 'Pale Banana',
                        'color_code' => '#F0E596',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Coral Sand',
                        'color_code' => '#F1966A',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#E4795C',
                    ],
                    [
                        'color' => 'Marmalade',
                        'color_code' => '#D5572A',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#802A3A',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Mauve Shadows',
                        'color_code' => '#BBA1B2',
                    ],
                    [
                        'color' => 'Heather Pink',
                        'color_code' => '#FAD8E8',
                    ],
                    [
                        'color' => 'Mint',
                        'color_code' => '#84CAC4',
                    ],
                    [
                        'color' => 'Baby Blue',
                        'color_code' => '#BDDDE4',
                    ],
                    [
                        'color' => 'Airy Blue',
                        'color_code' => '#9EC8EE',
                    ],
                    [
                        'color' => 'Harbour Blue',
                        'color_code' => '#147A7C',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Bottle Green',
                        'color_code' => '#20281B',
                    ],
                    [
                        'color' => 'Rosemary',
                        'color_code' => '#455646',
                    ],
                    [
                        'color' => 'Basil Green',
                        'color_code' => '#7EB36D',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Pumice Stone',
                        'color_code' => '#E3D7C6',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Ash Kode',
                        'color_code' => '#D5D2C9',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E8E9E4',
                    ],
                    [
                        'color' => 'Cucuza',
                        'color_code' => '#95C35C',
                    ],
                    [
                        'color' => 'Ink Blue',
                        'color_code' => '#316B81',
                    ],
                    [
                        'color' => 'Very Peri',
                        'color_code' => '#5A5E8B',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Downy (24s 185gsm)',
                'desc' => "T-shirt fabric made from 100% cotton fiber. Processed using a special treatment, resulting in high-quality cotton fabric at an affordable price.",
                'colors' => [
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Silver Sconce',
                        'color_code' => '#7B7C8E',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Super Sonic',
                        'color_code' => '#39649B',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Downy (30s 160gsm)',
                'desc' => "T-shirt fabric made from 100% cotton fiber. Processed using a special treatment, resulting in high-quality cotton fabric at an affordable price.",
                'colors' => [
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                ],
            ],
            [
                'name' => 'Twill Cotton (360gsm)',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI Supersoft (20s)',
                'desc' => "Made from 100% BCI combed cotton with a special supersoft treatment, this machine-combed fabric is widely used as raw material for premium, high-quality t-shirts.",
                'colors' => [
                    [
                        'color' => 'Lime',
                        'color_code' => '#B9D26C',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Deep Blue',
                        'color_code' => '#1F3D59',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Bleached Aqua',
                        'color_code' => '#B6DDD8',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Ocean Blue',
                        'color_code' => '#269ACD',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Flamingo',
                        'color_code' => '#DA7865',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'White Bluish',
                        'color_code' => '#F0F0F0',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI Supersoft (24s)',
                'desc' => "Made from 100% BCI combed cotton with a special supersoft treatment, this machine-combed fabric is widely used as raw material for premium, high-quality t-shirts.",
                'colors' => [
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Forest Green',
                        'color_code' => '#3B4D35',
                    ],
                    [
                        'color' => 'Granite Green',
                        'color_code' => '#4B644F',
                    ],
                    [
                        'color' => 'Feldspar',
                        'color_code' => '#80AD84',
                    ],
                    [
                        'color' => 'Fair Green',
                        'color_code' => '#93BB7D',
                    ],
                    [
                        'color' => 'Fuji Green',
                        'color_code' => '#237537',
                    ],
                    [
                        'color' => 'Island Green',
                        'color_code' => '#5AB050',
                    ],
                    [
                        'color' => 'Neon Green',
                        'color_code' => '#79B048',
                    ],
                    [
                        'color' => 'Sweet Pea',
                        'color_code' => '#94AF3D',
                    ],
                    [
                        'color' => 'Lime',
                        'color_code' => '#B9D26C',
                    ],
                    [
                        'color' => 'Golden Green',
                        'color_code' => '#C1B350',
                    ],
                    [
                        'color' => 'Green Sage',
                        'color_code' => '#8E8D61',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Military Green',
                        'color_code' => '#4F4B2E',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Sea Foam',
                        'color_code' => '#BECFBC',
                    ],
                    [
                        'color' => 'Celery Green',
                        'color_code' => '#BCDDCA',
                    ],
                    [
                        'color' => 'Pool Blue',
                        'color_code' => '#83C7B0',
                    ],
                    [
                        'color' => 'Tosca',
                        'color_code' => '#1A8279',
                    ],
                    [
                        'color' => 'Teal Blue',
                        'color_code' => '#042836',
                    ],
                    [
                        'color' => 'Deep Blue',
                        'color_code' => '#1F3D59',
                    ],
                    [
                        'color' => 'Mediaval Blue',
                        'color_code' => '#31375B',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Bleached Aqua',
                        'color_code' => '#B6DDD8',
                    ],
                    [
                        'color' => 'Cerulean',
                        'color_code' => '#C2D3DD',
                    ],
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Sky Blue',
                        'color_code' => '#6DA5C4',
                    ],
                    [
                        'color' => 'Ebb Flow',
                        'color_code' => '#5F75A6',
                    ],
                    [
                        'color' => 'Serenity Blue',
                        'color_code' => '#91A4E9',
                    ],
                    [
                        'color' => 'Powder Blue',
                        'color_code' => '#6B779C',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Indigo Blue',
                        'color_code' => '#31365E',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Supersonic',
                        'color_code' => '#33479D',
                    ],
                    [
                        'color' => 'Navagio',
                        'color_code' => '#348FA1',
                    ],
                    [
                        'color' => 'Ocean Blue',
                        'color_code' => '#269ACD',
                    ],
                    [
                        'color' => 'Peacock Blue',
                        'color_code' => '#1C4E6B',
                    ],
                    [
                        'color' => 'Midnight Plum',
                        'color_code' => '#1B1020',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Orchid',
                        'color_code' => '#AF7CB4',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Mulberry',
                        'color_code' => '#7A5066',
                    ],
                    [
                        'color' => 'Cedarwood',
                        'color_code' => '#AC7570',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Baby Pink',
                        'color_code' => '#DE97BB',
                    ],
                    [
                        'color' => 'Flamingo',
                        'color_code' => '#DA7865',
                    ],
                    [
                        'color' => 'Peach Nectar',
                        'color_code' => '#F1B09C',
                    ],
                    [
                        'color' => 'Blossom',
                        'color_code' => '#E6A57C',
                    ],
                    [
                        'color' => 'Peach',
                        'color_code' => '#EBC7B9',
                    ],
                    [
                        'color' => 'Candy Pink',
                        'color_code' => '#E4BDC2',
                    ],
                    [
                        'color' => 'Georgia Peach',
                        'color_code' => '#E49BA2',
                    ],
                    [
                        'color' => 'Bubble Gum',
                        'color_code' => '#E55C78',
                    ],
                    [
                        'color' => 'Fanta',
                        'color_code' => '#D41D49',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Red F-1',
                        'color_code' => '#AB1D1C',
                    ],
                    [
                        'color' => 'Viva Magenta',
                        'color_code' => '#44122B',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#3E161F',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Mineral Red',
                        'color_code' => '#7A393D',
                    ],
                    [
                        'color' => 'Plum',
                        'color_code' => '#5E2E3A',
                    ],
                    [
                        'color' => 'Brick Red',
                        'color_code' => '#853325',
                    ],
                    [
                        'color' => 'Orange',
                        'color_code' => '#C84D19',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#BA6A49',
                    ],
                    [
                        'color' => 'Sand',
                        'color_code' => '#DDBE7E',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Fragile Sprout',
                        'color_code' => '#D0D932',
                    ],
                    [
                        'color' => 'Antique Moss',
                        'color_code' => '#CCC602',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Pastel Yellow',
                        'color_code' => '#F7E986',
                    ],
                    [
                        'color' => 'Baby Yellow',
                        'color_code' => '#F7EDA8',
                    ],
                    [
                        'color' => 'Apricot Gold',
                        'color_code' => '#E4B302',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Tinsel',
                        'color_code' => '#C3A14B',
                    ],
                    [
                        'color' => 'Primerose White',
                        'color_code' => '#E5E0B8',
                    ],
                    [
                        'color' => 'Cream',
                        'color_code' => '#E0DED1',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'White Bluish',
                        'color_code' => '#F0F0F0',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Silver Sconce',
                        'color_code' => '#7B7C8E',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Sugar Swizzel',
                        'color_code' => '#E3DBC8',
                    ],
                    [
                        'color' => 'Grey',
                        'color_code' => '#A2A093',
                    ],
                    [
                        'color' => 'Popy Seed',
                        'color_code' => '#5B6365',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Macchiato',
                        'color_code' => '#4B3730',
                    ],
                    [
                        'color' => 'Cinnamon',
                        'color_code' => '#543213',
                    ],
                    [
                        'color' => 'Dessert Taupe',
                        'color_code' => '#61553F',
                    ],
                    [
                        'color' => 'Amber',
                        'color_code' => '#753327',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Almond Brown',
                        'color_code' => '#755642',
                    ],
                    [
                        'color' => 'Warm Taupe',
                        'color_code' => '#9A7A6B',
                    ],
                    [
                        'color' => 'Milk Tea',
                        'color_code' => '#B2A37C',
                    ],
                    [
                        'color' => 'Seneca Rock',
                        'color_code' => '#A3936F',
                    ],
                    [
                        'color' => 'Tillandsia Purple',
                        'color_code' => '#502D63',
                    ],
                    [
                        'color' => 'Elder Berry',
                        'color_code' => '#715E64',
                    ],
                    [
                        'color' => 'Dawn Pink',
                        'color_code' => '#B0959E',
                    ],
                    [
                        'color' => 'Emerald Blue',
                        'color_code' => '#24607A',
                    ],
                    [
                        'color' => 'Vanilla Iced',
                        'color_code' => '#F7F0D4',
                    ],
                    [
                        'color' => 'Miami Mist',
                        'color_code' => '#C9D3DC',
                    ],
                    [
                        'color' => 'Greenbriar',
                        'color_code' => '#5A9265',
                    ],
                    [
                        'color' => 'Tourmaline',
                        'color_code' => '#7B9AAE',
                    ],
                    [
                        'color' => 'Mojalica Blue',
                        'color_code' => '#113650',
                    ],
                    [
                        'color' => 'Biscoti',
                        'color_code' => '#E3D8BA',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI Supersoft (30s)',
                'desc' => "Made from 100% BCI combed cotton with a special supersoft treatment, this machine-combed fabric is widely used as raw material for premium, high-quality t-shirts.",
                'colors' => [
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Forest Green',
                        'color_code' => '#3B4D35',
                    ],
                    [
                        'color' => 'Granite Green',
                        'color_code' => '#4B644F',
                    ],
                    [
                        'color' => 'Feldspar',
                        'color_code' => '#80AD84',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Mediaval Blue',
                        'color_code' => '#31375B',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Cedarwood',
                        'color_code' => '#AC7570',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Baby Pink',
                        'color_code' => '#DE97BB',
                    ],
                    [
                        'color' => 'Flamingo',
                        'color_code' => '#DA7865',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Viva Magenta',
                        'color_code' => '#44122B',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#3E161F',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Plum',
                        'color_code' => '#5E2E3A',
                    ],
                    [
                        'color' => 'Brick Red',
                        'color_code' => '#853325',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#BA6A49',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'White Bluish',
                        'color_code' => '#F0F0F0',
                    ],
                    [
                        'color' => 'Grey',
                        'color_code' => '#A2A093',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Dessert Taupe',
                        'color_code' => '#61553F',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Milk Tea',
                        'color_code' => '#B2A37C',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Flace (280gsm)',
                'desc' => "Made with 100% cotton (Cotton Full), produced using special technology and treatment, resulting in a hoodie fabric that meets international standards.
                            The hallmark of NT's cotton place fabric is its neat, non-sticky inner lining.",
                'colors' => [
                    [
                        'color' => 'Pale Banana',
                        'color_code' => '#F0E596',
                    ],
                    [
                        'color' => 'Golden Green',
                        'color_code' => '#C1B350',
                    ],
                    [
                        'color' => 'Antique Moss',
                        'color_code' => '#CCC602',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Army Green',
                        'color_code' => '#26261A',
                    ],
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Green Spreed',
                        'color_code' => '#6C9675',
                    ],
                    [
                        'color' => 'Feldspar',
                        'color_code' => '#80AD84',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Mint',
                        'color_code' => '#84CAC4',
                    ],
                    [
                        'color' => 'Placid Blue',
                        'color_code' => '#8DCCDB',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Deep Blue',
                        'color_code' => '#1F3D59',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Royal Lilac',
                        'color_code' => '#765BA2',
                    ],
                    [
                        'color' => 'Irish Blue',
                        'color_code' => '#8790C5',
                    ],
                    [
                        'color' => 'Lilac',
                        'color_code' => '#D9CBDF',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Bush Orange',
                        'color_code' => '#E8CFC8',
                    ],
                    [
                        'color' => 'Light Pink',
                        'color_code' => '#F9DBE9',
                    ],
                    [
                        'color' => 'Mauve Shadows',
                        'color_code' => '#BBA1B2',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#802A3A',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Brick Red',
                        'color_code' => '#853325',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#E4795C',
                    ],
                    [
                        'color' => 'Rust Orange',
                        'color_code' => '#DB4825',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Silver Grey',
                        'color_code' => '#CDCAC8',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Coral Sand',
                        'color_code' => '#F1966A',
                    ],
                    [
                        'color' => 'Sea Mirst',
                        'color_code' => '#DFD8A7',
                    ],
                    [
                        'color' => 'Butterfly Green',
                        'color_code' => '#C8DA81',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Flace (330gsm)',
                'desc' => "Made with 100% cotton (Cotton Full), produced using special technology and treatment, resulting in a hoodie fabric that meets international standards.
                            The hallmark of NT's cotton place fabric is its neat, non-sticky inner lining.",
                'colors' => [
                    [
                        'color' => 'Army Green',
                        'color_code' => '#26261A',
                    ],
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#802A3A',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Pink',
                        'color_code' => '#E1A2B4',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Flace (375gsm)',
                'desc' => "Made with 100% cotton (Cotton Full), produced using special technology and treatment, resulting in a hoodie fabric that meets international standards.
                            The hallmark of NT's cotton place fabric is its neat, non-sticky inner lining.",
                'colors' => [
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Lilac',
                        'color_code' => '#D9CBDF',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                ],
            ],
            [
                'name' => 'Cotton French Terry (315gsm)',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Striper (20s)',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Navy - Maroon - Yellow',
                        'color_image' => 'cotton-striper(navy-maroon-yellow).PNG',
                    ],
                    [
                        'color' => 'Navy - Green - Red',
                        'color_image' => 'cotton-striper(navy-green-red).PNG',
                    ],
                    [
                        'color' => 'Navy - White - Blue',
                        'color_image' => 'cotton-striper(navy-white-blue).PNG',
                    ],
                    [
                        'color' => 'Navy - Green',
                        'color_image' => 'cotton-striper(navy-green).PNG',
                    ],
                    [
                        'color' => 'Navy - Dune',
                        'color_image' => 'cotton-striper(navy-dune).PNG',
                    ],
                    [
                        'color' => 'Black - Dune',
                        'color_image' => 'cotton-striper(black-dune).PNG',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Striper (24s)',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Black - White',
                        'color_image' => 'cotton-striper(black-white).PNG',
                    ],
                    [
                        'color' => 'Sand - White',
                        'color_image' => 'cotton-striper(sand-white).PNG',
                    ],
                    [
                        'color' => 'Navy - White',
                        'color_image' => 'cotton-striper(navy-white).PNG',
                    ],
                    [
                        'color' => 'Sky Blue - White',
                        'color_image' => 'cotton-striper(skyblue-white).PNG',
                    ],
                ],
            ],
            [
                'name' => 'Heavy Weight Cotton (250gsm)',
                'desc' => "Cotton Australia Coolbreeze uses 100% premium cotton, produced using high-tech technology and a special Coolbreeze treatment.
                            This makes the fabric extremely comfortable to wear in all weather, especially hot and humid conditions, and maintains its shape, meeting the requirements of oversized T-shirt sewing patterns.",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Silver Grey',
                        'color_code' => '#CDCAC8',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Gucci Green',
                        'color_code' => '#192F1A',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Meadiaval Blue',
                        'color_code' => '#132940',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Super Sonic',
                        'color_code' => '#39649B',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Lilac',
                        'color_code' => '#D9CBDF',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Bush Orange',
                        'color_code' => '#E8CFC8',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                ],
            ],
            [
                'name' => 'Heavy Weight Cotton (265gsm)',
                'desc' => "Cotton Australia Coolbreeze uses 100% premium cotton, produced using high-tech technology and a special Coolbreeze treatment.
                            This makes the fabric extremely comfortable to wear in all weather, especially hot and humid conditions, and maintains its shape, meeting the requirements of oversized T-shirt sewing patterns.",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                ],
            ],
            [
                'name' => 'Micro Cotton Danbowl 290gsm Coolbreeze',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White',
                        'color_code' => '#F2F2F0',
                    ],
                    [
                        'color' => 'Cream',
                        'color_code' => '#DCDBBC',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Steel Blue',
                        'color_code' => '#314462',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Light Green',
                        'color_code' => '#6E6E50',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                ],
            ],
            [
                'name' => 'Micro Cotton Danbowl 210gsm Coolbreeze',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White',
                        'color_code' => '#F2F2F0',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Greeny Grey',
                        'color_code' => '#514D43',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Steel Blue',
                        'color_code' => '#314462',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                ],
            ],
            [
                'name' => 'Micro Cotton Danbowl 185gsm Coolbreeze',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White',
                        'color_code' => '#F2F2F0',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Blue',
                        'color_code' => '#1E3152',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                ],
            ],
            [
                'name' => 'Micro Cotton Danbowl 200gsm',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White',
                        'color_code' => '#F2F2F0',
                    ],
                    [
                        'color' => 'Cream',
                        'color_code' => '#E0DED1',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Steel Blue',
                        'color_code' => '#314462',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                ],
            ],
            [
                'name' => 'Micro Fleece 200gsm',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Abu',
                        'color_code' => '#ACB2BD',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Maroon',
                        'color_code' => '#8C1A1C',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                ],
            ],
            [
                'name' => 'Pique CVC 24s',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Ocean Blue',
                        'color_code' => '#269ACD',
                    ],
                    [
                        'color' => 'Super Sonic',
                        'color_code' => '#39649B',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Fuji Green',
                        'color_code' => '#327E45',
                    ],
                    [
                        'color' => 'Morning Green',
                        'color_code' => '#4A6151',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Tinsel',
                        'color_code' => '#C3A14B',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Orange',
                        'color_code' => '#C84D19',
                    ],
                    [
                        'color' => 'Fanta',
                        'color_code' => '#D41D49',
                    ],
                    [
                        'color' => 'Red F-1',
                        'color_code' => '#AB1D1C',
                    ],
                    [
                        'color' => 'Maroon',
                        'color_code' => '#8C1A1C',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                ],
            ],
            [
                'name' => 'Poly Pique 20s',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Dijon',
                        'color_code' => '#A57929',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Micro Pique 32s',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                ],
            ],
            [
                'name' => 'DK Micro Cotton Pique Spandex 300gsm',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Abu',
                        'color_code' => '#ACB2BD',
                    ],
                    [
                        'color' => 'Cream',
                        'color_code' => '#E0DED1',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                    [
                        'color' => 'Brown Wood',
                        'color_code' => '#29241E',
                    ],
                ],
            ],
            [
                'name' => 'Micro Cotton Pique 225gsm',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                ],
            ],
            [
                'name' => 'Doubleknitt Micro Pique 300gsm',
                'desc' => "",
                'colors' => [
                    [
                        'color' => 'Black',
                        'color_code' => '#050505',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Khaky',
                        'color_code' => '#9B9585',
                    ],
                ],
            ],
            [
                'name' => 'Waffle Rib Orion Coolbreeze 235gsm',
                'desc' => "is a type of knitted fabric with a unique waffle-like texture. Made from a blend of CVC (Chief Value Cotton) fibers and treated with a special Coolbreeze treatment. It's perfect for making crewnecks or T-shirts for men, women, and kids.",
                'colors' => [
                    [
                        'color' => 'White',
                        'color_image' => 'waffle-rib-orion-coolbreeze(white).PNG',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_image' => 'waffle-rib-orion-coolbreeze(blacknt).PNG',
                    ],
                    [
                        'color' => 'Navy',
                        'color_image' => 'waffle-rib-orion-coolbreeze(navy).PNG',
                    ],
                    [
                        'color' => 'Stone Blue',
                        'color_image' => 'waffle-rib-orion-coolbreeze(stone-blue).PNG',
                    ],
                    [
                        'color' => 'Army Green',
                        'color_image' => 'waffle-rib-orion-coolbreeze(army-green).PNG',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_image' => 'waffle-rib-orion-coolbreeze(pastel-green).PNG',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_image' => 'waffle-rib-orion-coolbreeze(green-olive).PNG',
                    ],
                    [
                        'color' => 'Sage Green',
                        'color_image' => 'waffle-rib-orion-coolbreeze(sage-green).PNG',
                    ],
                    [
                        'color' => 'Rocky Road',
                        'color_image' => 'waffle-rib-orion-coolbreeze(rocky-road).PNG',
                    ],
                    [
                        'color' => 'Milo',
                        'color_image' => 'waffle-rib-orion-coolbreeze(milo).PNG',
                    ],
                    [
                        'color' => 'Cinnamon Stick',
                        'color_image' => 'waffle-rib-orion-coolbreeze(cinnamon-stick).PNG',
                    ],
                    [
                        'color' => 'Honey Ginger',
                        'color_image' => 'waffle-rib-orion-coolbreeze(honey-ginger).PNG',
                    ],
                    [
                        'color' => 'Brown',
                        'color_image' => 'waffle-rib-orion-coolbreeze(brown).PNG',
                    ],
                    [
                        'color' => 'Golden Brown',
                        'color_image' => 'waffle-rib-orion-coolbreeze(golden-brown).PNG',
                    ],
                    [
                        'color' => 'Curry',
                        'color_image' => 'waffle-rib-orion-coolbreeze(curry).PNG',
                    ],
                    [
                        'color' => 'Butter Scotch',
                        'color_image' => 'waffle-rib-orion-coolbreeze(butter-scotch).PNG',
                    ],
                    [
                        'color' => 'Coral Sands',
                        'color_image' => 'waffle-rib-orion-coolbreeze(coral-sands).PNG',
                    ],
                    [
                        'color' => 'Rose Cloud',
                        'color_image' => 'waffle-rib-orion-coolbreeze(rose-cloud).PNG',
                    ],
                    [
                        'color' => 'Beige',
                        'color_image' => 'waffle-rib-orion-coolbreeze(beige).PNG',
                    ],
                    [
                        'color' => 'Warm Taupe',
                        'color_image' => 'waffle-rib-orion-coolbreeze(warm-taupe).PNG',
                    ],
                    [
                        'color' => 'Grey',
                        'color_image' => 'waffle-rib-orion-coolbreeze(grey).PNG',
                    ],
                    [
                        'color' => 'Ash',
                        'color_image' => 'waffle-rib-orion-coolbreeze(ash).PNG',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI 20s',
                'desc' => "Made from 100% BCI Combed Cotton. The raw material comes from the world's finest combed cotton fibers, which are smoother and cleaner. Dyed with selected reactive dyes, ensuring safe color removal (discharge).",
                'colors' => [
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI 20s',
                'desc' => "Made from 100% BCI Combed Cotton. The raw material comes from the world's finest combed cotton fibers, which are smoother and cleaner. Dyed with selected reactive dyes, ensuring safe color removal (discharge).",
                'colors' => [
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Crocodile',
                        'color_code' => '#0A3419',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Military Olive',
                        'color_code' => '#4A4729',
                    ],
                    [
                        'color' => 'Army Green',
                        'color_code' => '#26261A',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Green Sage',
                        'color_code' => '#8E8D61',
                    ],
                    [
                        'color' => 'Fair Green',
                        'color_code' => '#93BB7D',
                    ],
                    [
                        'color' => 'Lime',
                        'color_code' => '#B9D26C',
                    ],
                    [
                        'color' => 'Fragile Sprout',
                        'color_code' => '#D0D932',
                    ],
                    [
                        'color' => 'Warm Olive',
                        'color_code' => '#CBC64F',
                    ],
                    [
                        'color' => 'Golden Green',
                        'color_code' => '#C1B350',
                    ],
                    [
                        'color' => 'Island Green',
                        'color_code' => '#5AB050',
                    ],
                    [
                        'color' => 'Fuji Green',
                        'color_code' => '#237537',
                    ],
                    [
                        'color' => 'Tosca',
                        'color_code' => '#1A8279',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Feldspar',
                        'color_code' => '#80AD84',
                    ],
                    [
                        'color' => 'Sea Foam',
                        'color_code' => '#BECFBC',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Pool Blue',
                        'color_code' => '#83C7B0',
                    ],
                    [
                        'color' => 'Yucca',
                        'color_code' => '#B9E8D7',
                    ],
                    [
                        'color' => 'Celery Green',
                        'color_code' => '#BCDDCA',
                    ],
                    [
                        'color' => 'Bleached Aqua',
                        'color_code' => '#B6DDD8',
                    ],
                    [
                        'color' => 'Cerulean',
                        'color_code' => '#C2D3DD',
                    ],
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Denim Blue',
                        'color_code' => '#324765',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Steel Blue',
                        'color_code' => '#314462',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Navagio',
                        'color_code' => '#348FA1',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Super Sonic',
                        'color_code' => '#39649B',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Mediaval Blue',
                        'color_code' => '#31375B',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Indigo Blue',
                        'color_code' => '#31365E',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Candy Pink',
                        'color_code' => '#E4BDC2',
                    ],
                    [
                        'color' => 'Baby Pink',
                        'color_code' => '#DE97BB',
                    ],
                    [
                        'color' => 'Bubble Gum',
                        'color_code' => '#E55C78',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Cedarwood',
                        'color_code' => '#AC7570',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Viva Magenta',
                        'color_code' => '#44122B',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#3E161F',
                    ],
                    [
                        'color' => 'Plum',
                        'color_code' => '#5E2E3A',
                    ],
                    [
                        'color' => 'Brick Red',
                        'color_code' => '#853325',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#E4795C',
                    ],
                    [
                        'color' => 'Orange',
                        'color_code' => '#C84D19',
                    ],
                    [
                        'color' => 'Bright Orange',
                        'color_code' => '#F2733C',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Antique Moss',
                        'color_code' => '#CCC602',
                    ],
                    [
                        'color' => 'Pastel Yellow',
                        'color_code' => '#F7E986',
                    ],
                    [
                        'color' => 'Baby Yellow',
                        'color_code' => '#F7EDA8',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Sand',
                        'color_code' => '#DDBE7E',
                    ],
                    [
                        'color' => 'Peach',
                        'color_code' => '#EBC7B9',
                    ],
                    [
                        'color' => 'Tinsel',
                        'color_code' => '#C3A14B',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Almond Brown',
                        'color_code' => '#755642',
                    ],
                    [
                        'color' => 'Cinnamon',
                        'color_code' => '#543213',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Warm Taupe',
                        'color_code' => '#9A7A6B',
                    ],
                    [
                        'color' => 'Dessert Taupe',
                        'color_code' => '#61553F',
                    ],
                    [
                        'color' => 'Seneca Rock',
                        'color_code' => '#A3936F',
                    ],
                    [
                        'color' => 'Primerose White',
                        'color_code' => '#E5E0B8',
                    ],
                    [
                        'color' => 'Sugar Swizzel',
                        'color_code' => '#E3DBC8',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'White Bluish',
                        'color_code' => '#F0F0F0',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Silver Sconce',
                        'color_code' => '#7B7C8E',
                    ],
                    [
                        'color' => 'Grey',
                        'color_code' => '#A2A093',
                    ],
                    [
                        'color' => 'Popy Seed',
                        'color_code' => '#5B6365',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Deep Blue',
                        'color_code' => '#1F3D59',
                    ],
                    [
                        'color' => 'Sky Blue',
                        'color_code' => '#6DA5C4',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI 24s',
                'desc' => "Made from 100% BCI Combed Cotton. The raw material comes from the world's finest combed cotton fibers, which are smoother and cleaner. Dyed with selected reactive dyes, ensuring safe color removal (discharge).",
                'colors' => [
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Crocodile',
                        'color_code' => '#0A3419',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Army Green',
                        'color_code' => '#26261A',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Fair Green',
                        'color_code' => '#93BB7D',
                    ],
                    [
                        'color' => 'Lime',
                        'color_code' => '#B9D26C',
                    ],
                    [
                        'color' => 'Fragile Sprout',
                        'color_code' => '#D0D932',
                    ],
                    [
                        'color' => 'Warm Olive',
                        'color_code' => '#CBC64F',
                    ],
                    [
                        'color' => 'Golden Green',
                        'color_code' => '#C1B350',
                    ],
                    [
                        'color' => 'Island Green',
                        'color_code' => '#5AB050',
                    ],
                    [
                        'color' => 'Fuji Green',
                        'color_code' => '#237537',
                    ],
                    [
                        'color' => 'Tosca',
                        'color_code' => '#1A8279',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Sea Foam',
                        'color_code' => '#BECFBC',
                    ],
                    [
                        'color' => 'Harbour Gray',
                        'color_code' => '#A3C4B9',
                    ],
                    [
                        'color' => 'Pool Blue',
                        'color_code' => '#83C7B0',
                    ],
                    [
                        'color' => 'Yucca',
                        'color_code' => '#B9E8D7',
                    ],
                    [
                        'color' => 'Celery Green',
                        'color_code' => '#BCDDCA',
                    ],
                    [
                        'color' => 'Bleached Aqua',
                        'color_code' => '#B6DDD8',
                    ],
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Super Sonic',
                        'color_code' => '#39649B',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Mediaval Blue',
                        'color_code' => '#31375B',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#101727',
                    ],
                    [
                        'color' => 'Indigo Blue',
                        'color_code' => '#31365E',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Candy Pink',
                        'color_code' => '#E4BDC2',
                    ],
                    [
                        'color' => 'Baby Pink',
                        'color_code' => '#DE97BB',
                    ],
                    [
                        'color' => 'Bubble Gum',
                        'color_code' => '#E55C78',
                    ],
                    [
                        'color' => 'Dusty Pink',
                        'color_code' => '#DEA68B',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#3E161F',
                    ],
                    [
                        'color' => 'Brick Red',
                        'color_code' => '#853325',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#E4795C',
                    ],
                    [
                        'color' => 'Orange',
                        'color_code' => '#C84D19',
                    ],
                    [
                        'color' => 'Bright Orange',
                        'color_code' => '#F2733C',
                    ],
                    [
                        'color' => 'Lemon',
                        'color_code' => '#EDCE3A',
                    ],
                    [
                        'color' => 'Antique Moss',
                        'color_code' => '#CCC602',
                    ],
                    [
                        'color' => 'Pastel Yellow',
                        'color_code' => '#F7E986',
                    ],
                    [
                        'color' => 'Baby Yellow',
                        'color_code' => '#F7EDA8',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Sand',
                        'color_code' => '#DDBE7E',
                    ],
                    [
                        'color' => 'Peach',
                        'color_code' => '#EBC7B9',
                    ],
                    [
                        'color' => 'Tinsel',
                        'color_code' => '#C3A14B',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Seneca Rock',
                        'color_code' => '#A3936F',
                    ],
                    [
                        'color' => 'Primerose White',
                        'color_code' => '#E5E0B8',
                    ],
                    [
                        'color' => 'Sugar Swizzel',
                        'color_code' => '#E3DBC8',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'Silver Sconce',
                        'color_code' => '#7B7C8E',
                    ],
                    [
                        'color' => 'Popy Seed',
                        'color_code' => '#5B6365',
                    ],
                    [
                        'color' => 'Dark Grey',
                        'color_code' => '#3B3B3B',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Deep Blue',
                        'color_code' => '#1F3D59',
                    ],
                ],
            ],
            [
                'name' => 'Cotton Combed BCI 30s',
                'desc' => "Made from 100% BCI Combed Cotton. The raw material comes from the world's finest combed cotton fibers, which are smoother and cleaner. Dyed with selected reactive dyes, ensuring safe color removal (discharge).",
                'colors' => [
                    [
                        'color' => 'Sycamore',
                        'color_code' => '#1F2B1D',
                    ],
                    [
                        'color' => 'Crocodile',
                        'color_code' => '#0A3419',
                    ],
                    [
                        'color' => 'Olive',
                        'color_code' => '#24261B',
                    ],
                    [
                        'color' => 'Military Olive',
                        'color_code' => '#4A4729',
                    ],
                    [
                        'color' => 'Green Olive',
                        'color_code' => '#717239',
                    ],
                    [
                        'color' => 'Green Sage',
                        'color_code' => '#8E8D61',
                    ],
                    [
                        'color' => 'Fair Green',
                        'color_code' => '#93BB7D',
                    ],
                    [
                        'color' => 'Lime',
                        'color_code' => '#B9D26C',
                    ],
                    [
                        'color' => 'Fragile Sprout',
                        'color_code' => '#D0D932',
                    ],
                    [
                        'color' => 'Warm Olive',
                        'color_code' => '#CBC64F',
                    ],
                    [
                        'color' => 'Golden Green',
                        'color_code' => '#C1B350',
                    ],
                    [
                        'color' => 'Fuji Green',
                        'color_code' => '#237537',
                    ],
                    [
                        'color' => 'Pastel Green',
                        'color_code' => '#717F6D',
                    ],
                    [
                        'color' => 'Feldspar',
                        'color_code' => '#80AD84',
                    ],
                    [
                        'color' => 'Yucca',
                        'color_code' => '#B9E8D7',
                    ],
                    [
                        'color' => 'Celery Green',
                        'color_code' => '#BCDDCA',
                    ],
                    [
                        'color' => 'Cerulean',
                        'color_code' => '#C2D3DD',
                    ],
                    [
                        'color' => 'Blue Bell',
                        'color_code' => '#93B9CE',
                    ],
                    [
                        'color' => 'Denim Blue',
                        'color_code' => '#324765',
                    ],
                    [
                        'color' => 'Bering Sea',
                        'color_code' => '#4B666F',
                    ],
                    [
                        'color' => 'Steel Blue',
                        'color_code' => '#314462',
                    ],
                    [
                        'color' => 'Blue Stone',
                        'color_code' => '#557B7E',
                    ],
                    [
                        'color' => 'Navagio',
                        'color_code' => '#348FA1',
                    ],
                    [
                        'color' => 'Turquise',
                        'color_code' => '#084888',
                    ],
                    [
                        'color' => 'Royal Benhur',
                        'color_code' => '#0D1C79',
                    ],
                    [
                        'color' => 'Benhur',
                        'color_code' => '#1A1D7E',
                    ],
                    [
                        'color' => 'Navy',
                        'color_code' => '#0F1629',
                    ],
                    [
                        'color' => 'Dark Purple',
                        'color_code' => '#332562',
                    ],
                    [
                        'color' => 'Lilac NT',
                        'color_code' => '#D3B8D9',
                    ],
                    [
                        'color' => 'Cedarwood',
                        'color_code' => '#AC7570',
                    ],
                    [
                        'color' => 'Red',
                        'color_code' => '#D92F2D',
                    ],
                    [
                        'color' => 'Heart Red',
                        'color_code' => '#A02129',
                    ],
                    [
                        'color' => 'Viva Magenta',
                        'color_code' => '#44122B',
                    ],
                    [
                        'color' => 'Burgundy',
                        'color_code' => '#3E161F',
                    ],
                    [
                        'color' => 'Plum',
                        'color_code' => '#5E2E3A',
                    ],
                    [
                        'color' => 'Carnelian',
                        'color_code' => '#E4795C',
                    ],
                    [
                        'color' => 'Bright Orange',
                        'color_code' => '#F2733C',
                    ],
                    [
                        'color' => 'Pastel Yellow',
                        'color_code' => '#F7E986',
                    ],
                    [
                        'color' => 'Beige',
                        'color_code' => '#DDCBB6',
                    ],
                    [
                        'color' => 'Rotten Yellow',
                        'color_code' => '#E19921',
                    ],
                    [
                        'color' => 'Brown',
                        'color_code' => '#9E622B',
                    ],
                    [
                        'color' => 'Cofee',
                        'color_code' => '#3B2925',
                    ],
                    [
                        'color' => 'Almond Brown',
                        'color_code' => '#755642',
                    ],
                    [
                        'color' => 'Cinnamon',
                        'color_code' => '#543213',
                    ],
                    [
                        'color' => 'Coca Mocha',
                        'color_code' => '#77512F',
                    ],
                    [
                        'color' => 'Warm Taupe',
                        'color_code' => '#9A7A6B',
                    ],
                    [
                        'color' => 'Dessert Taupe',
                        'color_code' => '#61553F',
                    ],
                    [
                        'color' => 'Seneca Rock',
                        'color_code' => '#A3936F',
                    ],
                    [
                        'color' => 'Sugar Swizzel',
                        'color_code' => '#E3DBC8',
                    ],
                    [
                        'color' => 'White Netral',
                        'color_code' => '#E7E8E3',
                    ],
                    [
                        'color' => 'White Bluish',
                        'color_code' => '#F0F0F0',
                    ],
                    [
                        'color' => 'Misty 71',
                        'color_code' => '#92A0A2',
                    ],
                    [
                        'color' => 'Grey',
                        'color_code' => '#A2A093',
                    ],
                    [
                        'color' => 'Popy Seed',
                        'color_code' => '#5B6365',
                    ],
                    [
                        'color' => 'Black NT',
                        'color_code' => '#070707',
                    ],
                    [
                        'color' => 'Sky Blue',
                        'color_code' => '#6DA5C4',
                    ],
                ],
            ],
        ];

        if($filter_name){
            $new_data = array_values(
                array_filter($data, fn($item) => $item['name'] === $filter_name)
            )[0] ?? null;

            return $new_data;
        }

        return $data;
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $structure = [
            'Agricultura e Pecuária' => [
                'slug' => 'agricultura-e-pecuaria',
                'subs' => [
                    'Agricultura', 'Pecuária', 'Soja', 'Milho', 'Café', 
                    'Cana-de-Açúcar', 'Hortifruti', 'Bovinocultura de Corte', 
                    'Bovinocultura de Leite', 'Avicultura', 'Suinocultura', 'Sanidade Animal'
                ]
            ],
            'Agronegócio' => [
                'slug' => 'agronegocio',
                'subs' => [
                    'Mercado Agro', 'Commodities', 'Exportações', 'Importações',
                    'Tecnologia no Agro', 'Máquinas Agrícolas', 'Crédito Rural', 'Políticas Agrícolas'
                ]
            ],
            'Meio Ambiente e Sustentabilidade' => [
                'slug' => 'meio-ambiente-e-sustentabilidade',
                'subs' => [
                    'Agricultura Sustentável', 'ESG no Agro', 'Clima', 
                    'Impactos Ambientais', 'Legislação Ambiental', 'Créditos de Carbono', 'Recuperação de Áreas'
                ]
            ],
            'Mundo Pet' => [
                'slug' => 'mundo-pet',
                'subs' => [
                    'Cães', 'Gatos', 'Saúde Pet', 'Alimentação Pet', 
                    'Comportamento Pet', 'Curiosidades Pet'
                ]
            ],
        ];

        foreach ($structure as $parentName => $data) {
            $parent = Category::firstOrCreate(
                ['slug' => $data['slug']],
                ['name' => $parentName]
            );

            foreach ($data['subs'] as $subName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($subName)],
                    [
                        'name' => $subName,
                        'parent_id' => $parent->id
                    ]
                );
            }
        }
    }
}

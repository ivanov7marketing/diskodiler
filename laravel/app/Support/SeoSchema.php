<?php

namespace App\Support;

final class SeoSchema
{
    /**
     * @param  array<int, array{question: string, answer: string}>  $items
     * @return array<string, mixed>
     */
    public static function faqPage(array $items): array
    {
        $entities = collect($items)
            ->filter(fn (array $item) => filled($item['question'] ?? null) && filled($item['answer'] ?? null))
            ->map(fn (array $item) => [
                '@type' => 'Question',
                'name' => self::cleanText($item['question']),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => self::cleanText($item['answer']),
                ],
            ])
            ->values()
            ->all();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    /**
     * @param  array<int, array{name: string, item: string}>  $items
     * @return array<string, mixed>
     */
    public static function breadcrumbList(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)
                ->values()
                ->map(fn (array $item, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => self::cleanText($item['name']),
                    'item' => $item['item'],
                ])
                ->all(),
        ];
    }

    private static function cleanText(string $text): string
    {
        return trim((string) preg_replace('/\s+/', ' ', strip_tags($text)));
    }
}

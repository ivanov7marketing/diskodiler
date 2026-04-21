User-agent: *
@if (config('app.prevent_indexing'))
Disallow: /
@else
Allow: /
Disallow: /admin
Disallow: /proposal.html
Disallow: /admin-leads.html

Sitemap: {{ route('seo.sitemap') }}
@endif

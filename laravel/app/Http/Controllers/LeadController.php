<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Support\LeadAttribution;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['nullable', 'string', 'max:80'],
            'goal' => ['nullable', 'string', 'max:120'],
            'page' => ['nullable', 'string', 'max:255'],
            'fields' => ['nullable', 'array'],
            'utm' => ['nullable', 'array'],
            'vin' => ['nullable', 'string', 'max:64'],
            'referer_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $fields = $data['fields'] ?? [];
        $sourcePage = LeadAttribution::normalizeSourcePage($data['page'] ?? $request->headers->get('referer'));
        $refererUrl = LeadAttribution::normalizeRefererUrl($data['referer_url'] ?? $request->headers->get('referer'));
        $refererHost = LeadAttribution::extractRefererHost($refererUrl);
        $utm = is_array($data['utm'] ?? null) ? $data['utm'] : [];

        $lead = Lead::create([
            'type' => $data['type'] ?? 'lead',
            'status' => 'new',
            'name' => $fields['name'] ?? null,
            'phone' => $fields['phone'] ?? null,
            'contact_method' => $fields['contactMethod'] ?? $fields['contact_method'] ?? null,
            'telegram' => $fields['telegram'] ?? null,
            'vin' => $data['vin'] ?? $fields['vin'] ?? null,
            'message' => $fields['message'] ?? $fields['city'] ?? null,
            'source_page' => $sourcePage,
            'referer_url' => $refererUrl,
            'referer_host' => $refererHost,
            'traffic_channel' => LeadAttribution::determineTrafficChannel($utm, $refererHost),
            'goal' => $data['goal'] ?? null,
            'utm' => $utm,
            'payload' => $fields,
        ]);

        return response()->json([
            'ok' => true,
            'id' => $lead->id,
        ], 201);
    }
}

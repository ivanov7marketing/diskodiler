<?php

namespace App\Http\Controllers;

use App\Models\Lead;
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
        ]);

        $fields = $data['fields'] ?? [];

        $lead = Lead::create([
            'type' => $data['type'] ?? 'lead',
            'status' => 'new',
            'name' => $fields['name'] ?? null,
            'phone' => $fields['phone'] ?? null,
            'contact_method' => $fields['contactMethod'] ?? $fields['contact_method'] ?? null,
            'telegram' => $fields['telegram'] ?? null,
            'vin' => $data['vin'] ?? $fields['vin'] ?? null,
            'message' => $fields['message'] ?? $fields['city'] ?? null,
            'source_page' => $data['page'] ?? $request->headers->get('referer'),
            'goal' => $data['goal'] ?? null,
            'utm' => $data['utm'] ?? [],
            'payload' => $fields,
        ]);

        return response()->json([
            'ok' => true,
            'id' => $lead->id,
        ], 201);
    }
}

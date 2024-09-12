<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Search products.
     */
    public function search() :JsonResponse
    {
        $client = app('Elasticsearch');

        // Initialize the scroll
        $params = [
            'index' => 'products',
            'scroll' => '1m', // Scroll duration
            'size' => 1000, // Number of documents per batch
            'body' => [
                'query' => [
                    'match_all' => (object)[], // Match all documents
                ],
            ],
        ];

        $response = $client->search($params);

        $scrollId = $response['_scroll_id'];
        $hits = $response['hits']['hits'];

        $allHits = $hits;

        while (count($hits) > 0) {
            // Fetch the next batch of results
            $response = $client->scroll([
                'scroll_id' => $scrollId,
                'scroll' => '1m',
            ]);

            $scrollId = $response['_scroll_id'];
            $hits = $response['hits']['hits'];

            $allHits = array_merge($allHits, $hits);
        }

        // Clear the scroll context
        $client->clearScroll([
            'scroll_id' => $scrollId,
        ]);

        return response()->json([
            'total' => count($allHits),
            'hits' => $allHits,
        ]);
    }
    public function searchNormal(Request $request):JsonResponse
    {
        $query = $request->input('query');

        $response = app('Elasticsearch')->search([
            'index' => 'products',
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'wildcard' => [
                                    'name' => '*' . $query . '*',  // Match any name containing the query term
                                ],
                            ],
                            [
                                'wildcard' => [
                                    'description' => '*' . $query . '*',  // Match any description containing the query term
                                ],
                            ],
                        ],
                    ],
                ],
                'from' => 0,
                'size' => 10000,
            ],
        ]);

        /** @phpstan-ignore-next-line */
        return response()->json($response['hits']['hits']);
        
    }
    /**
     * Store a new product.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric',
    //     ]);

    //     $product = Product::create($request->all());

    //     return response()->json($product, 201);
    // }

    /**
     * Get a product by ID.
     */
    // public function show($id)
    // {
    //     $product = Product::findOrFail($id);

    //     return response()->json($product);
    // }

    /**
     * Update a product by ID.
     */
    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $product->update($request->all());

    //     return response()->json($product);
    // }

    /**
     * Delete a product by ID.
     */
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);

    //     $product->delete();

    //     return response()->json(null, 204);
    // }
}


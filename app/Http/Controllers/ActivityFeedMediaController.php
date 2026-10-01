<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityFeedMediaController extends Controller
{
    public function index() {}

    public function getActivityFeedMedia(Request $request)
    {
        try {
            $data = [];
            $data['url'] = $request->get('url');
            $data['filename'] = $request->get('filename');
            $data['mime_type'] = $request->get('mime_type');

            // Validate required parameters
            if (! $data['url'] || ! $data['filename'] || ! $data['mime_type']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Missing required parameters: url, filename, mime_type',
                ], 400);
            }

            $path = 'app/public'.$data['url'].'/'.$data['filename'];
            $fullPath = storage_path($path);

            // Check if file exists
            if (! file_exists($fullPath)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found: '.$path,
                ], 404);
            }

            return response()->file(
                $fullPath,
                [
                    'Content-Type' => $data['mime_type'],
                    'Content-disposition' => 'filename="'.$data['filename'].'"',
                ]
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Post not found or user not authorized',
                    'data' => null,
                ],
                404
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed: '.$e->getMessage(),
                    'data' => null,
                ],
                422
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                    'data' => null,
                ],
                500
            );
        }
    }
}

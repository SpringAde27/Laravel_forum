<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attachments = [];

        if ($request->hasFile('files')) {
            $files = $request->file('files');

            foreach($files as $file) {
                $filename = \Str::random().filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);

                $payload = [
                    'filename' => $filename,
                    'bytes' => $file->getClientSize(),
                    'mime' => $file->getClientMimeType()
                ];

                $file->move(attachments_path(), $filename);

                $attachments[] = ($id = $request->input('article_id'))
                    ? \App\Article::findOrFail($id)->attachments()->create($payload)
                    : \App\Attachment::create($payload);
            }
        }

        return response()->json($attachments, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Attachment $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Attachment $attachment)
    {
        $path = attachments_path($attachment->name);

        if (\File::exists($path)) {
            \File::delete($path);
        }

        $attachment->delete();

        // ajax로 삭제 처리 했을 경우
        if (\Request::ajax()) {
            return response()->json(['status' => 'ok'], 200, [], JSON_PRETTY_PRINT);
        }

        flash()->success('첨부파일을 삭제하였습니다.');

        return back();
        // return response()->json([], 204);
    }

    /**
     * Display the specified resource.
     *
     * @param $file
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show($file)
    {
        $path = attachments_path($file);

        if (! \File::exists($path)) {
            abort(404);
        }

        $image = \Image::make($path);

        return response($image->encode('png'), 200, ['Content-Type' => 'image/png']);
    }
}

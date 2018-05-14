<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function info()
    {
//        $content = $this->parseMarkdown('info.md');

        return view('info');
    }

//    public function style()
//    {
//        $content = $this->parseMarkdown('style.md');
//
//        return view('page', compact('content'));
//    }

//    protected function parseMarkdown(string $page)
//    {
//        try {
//            $markdown = Storage::disk('pages')->get("/{$page}");
//        } catch (Exception $e) {
//            abort(404);
//        }
//
//        $converter = new CommonMarkConverter();
//
//        return $converter->convertToHtml($markdown);
//    }
}

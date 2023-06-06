<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    use ReportTrait;
    public function fetchReport()
    {
        $reports = Report::get();
        foreach ($reports as $report) {
            $this->_convertObjectTypeReport($report);
        }
        return response()->json($reports, 200);
    }
    public function fetchReportById($reportId)
    {
        $report = Report::find($reportId);
        $this->_convertObjectTypeReport($report);
        return response()->json($report, 200);
    }

    public function checkTheReport(Request $request)
    {
        $change = $request->change; //? delete or not delete the reported object (1 or 0)
        $report = Report::find($request->reportId);
        if ($change === 1) {
            if ($report) {
                if ($report->object_type === 1) {
                    $post = Post::find($report->object_id);
                    $post->delete();
                }
            } else {
                return response->json('Không tìm thấy đối tượng yêu cầu!', 404);
            }
        }
        $report->isProcessed = 1;
        $report->update();
        return response()->json($report, 200);
    }
}

trait ReportTrait
{
    private function _convertObjectTypeReport(Report $report): void
    {
        $report->owner = $report->user->displayName;
        if ($report->object_type === 1) {
            $report->objectType = 'Bài viết';
            $post = Post::Where('id', $report->object_id)->withTrashed()->first();

            $report->violators = $post->user->displayName;
            $report->typeReport = $report->conent_report;
            $report->objectId = $post->id;
        } else {
            $report->typeName = 'Bản tin';
        }
        $report->status = $report->isProcessed === 0 ? 'Đang chờ xử lý' : 'Đã xử lý';
    }
}

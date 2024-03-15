<?php

namespace App\Http\Controllers;

use App\Models\permission;
use App\Models\project;
use App\Models\status;
use App\Models\task;
use App\Models\User;
use App\Models\worker;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class TaskManagementController extends Controller
{

    public function addStatus(Request $request)
    {

        try {
            $request->validate([
                "status_name" => "required",
            ]);

            $status = status::create(
                [
                    "status_name" => $request['status_name'],
                ]
            );
            return response()->json($data = 'Add status successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function addProject(Request $request)
    {

        try {
            $request->validate([
                'user_infor_id'  => "required",
                "project_name" => "required",
            ]);

            $project = project::create(
                [
                    "user_infor_id" => $request['user_infor_id'],
                    "project_name" => $request['project_name'],
                ]
            );
            return response()->json($data = 'Add project successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function addTask(Request $request)
    {

        try {
            $request->validate([
                "project_id" => "required",
                "task_name" => "required",
                "task_dealine" => "required| date_format:Y-m-d",
                "task_tag" => "required",
                "user_infor_id" => "required",

            ]);

            $task = task::create(
                [
                    "status_id" => 1,
                    "project_id" => $request["project_id"],
                    "task_name" => $request["task_name"],
                    "task_dealine" => $request["task_dealine"],
                    "task_tag" => $request["task_tag"],
                ]
            );

            $task->worker()->create([
                "user_infor_id" => $request["user_infor_id"]
            ]);
            $task->permission()->create([
                "user_infor_id" => $request["user_infor_id"]
            ]);

            return response()->json($data = 'Add task successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function addUserInProject(Request $request)
    {

        try {
            $request->validate([
                "user_infor_id" => "required",
                "task_id" => "required",
            ]);

            $worker = worker::create(
                [
                    "user_infor_id" => $request['user_infor_id'],
                    "task_id" => $request['task_id'],
                ]
            );

            $permission = permission::create(
                [
                    "user_infor_id" => $request['user_infor_id'],
                    "task_id" => $request['task_id'],
                ]
            );

            return response()->json($data = 'Add user to worker successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function editStatusTask(Request $request)
    {
        try {
            $request->validate([
                "user_infor_id" => "required",
                "task_id" => "required",
                "status_id" => "required"
            ]);

            $worker = worker::where(
                [
                    ["user_infor_id", $request['user_infor_id']],
                    ["task_id", $request['task_id']],
                ]
            )->first();
            if (!$worker) {
                return response()->json($data = 'Work not for you', $status = 401);
            }

            $permission = permission::where(
                [
                    ["user_infor_id", $request['user_infor_id']],
                    ["task_id", $request['task_id']],
                    ["write", 1],

                ]
            )->first();

            if (!$permission) {
                return response()->json($data = 'You not have updating permission', $status = 401);
            }

            task::where([
                ['id', $request['task_id']]
            ])->update(['status_id' => $request["status_id"]]);

            return response()->json($data = 'Update task status successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function editPermission(Request $request)
    {
        try {
            $request->validate([
                "user_infor_id" => "required",
                "task_id" => "required",
                "read" => "required",
                "write" => "required"
            ]);

            $permission = permission::where(
                [
                    ["user_infor_id", $request['user_infor_id']],
                    ["task_id", $request['task_id']],
                ]
            )->first();

            if (!$permission) {

                return response()->json($data = 'User not working in this task', $status = 200);
            }

            permission::where([
                ['user_infor_id', $request['user_infor_id']],
                ['task_id', $request['task_id']],
            ])->update(
                [
                    'write' => $request['write'],
                    'read' => $request['read'],
                ]
            );

            return response()->json($data = 'Update task permission successfully', $status = 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function editDealine(Request $request)
    {
        try {

            $request->validate([
                "task_id" => "required",
                "dealine" => "required| date_format:Y-m-d",
                "user_id" => "required",
            ]);

            $user = User::where('id', $request["user_id"])->first();
            if (!$user) return response()->json($data = "Not found user", $status = 200);
            if ($user['group'] != 0) {
                return response()->json($data = "You are not Admin", $status = 200);
            }
            task::where('id', $request['task_id'])->update([
                'task_dealine' => $request['dealine']
            ]);

            return response()->json($data = "Update dealine successfull", $status = 200);
        } catch (\Exception $error) {
            return $error;
        }
    }

    public function getproject(Request $request)
    {
        try {

            $projects = project::get();
            foreach ($projects as $item) {
                $item->task;
            }
            //  $projects->task;
            return response()->json($data = ['project' => $projects], $status = 200);
        } catch (\Exception $error) {
            return $error;
        }
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Class\ClassModel;
use DB;
class StudentController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
    $student = Student::with('class')->get();
    $paginate = Student::orderBy('id_student', 'asc')->paginate(3);
    return view('student.index', ['student' => $student,'paginate'=>$paginate]);
 }
 public function create()
 {
 return view('student.create');
 }
 public function store(Request $request)
 {
 //melakukan validasi data
 $request->validate([
 'Nim' => 'required',
 'Name' => 'required',
 'Class' => 'required',
 'Major' => 'required', 
 ]); // eloquent function to add data
 Student::create($request->all());
 // if the data is added successfully, will return to the main page
 return redirect()->route('student.index')
 ->with('success', 'Student Successfully Added');
 }
 public function show($Nim)
 {
 // displays detailed data by finding / by Student Nim
 $Student = Student::find($Nim);
 return view('student.detail', compact('Student'));
 }
 public function edit($Nim)
 {
// displays detail data by finding based on Student Nim for editing
 $Student = DB::table('student')->where('nim', $Nim)->first();;
 return view('student.edit', compact('Student'));
 }
 public function update(Request $request, $Nim)
 {
//validate the data
 $request->validate([
 'Nim' => 'required',
 'Name' => 'required',
 'Class' => 'required',
 'Major' => 'required', 
 ]);
//Eloquent function to update the data
 Student::find($Nim)->update($request->all());
//if the data successfully updated, will return to main page
 return redirect()->route('student.index')
 ->with('success', 'Student Successfully Updated');
 }
 public function destroy( $Nim)
 {
//Eloquent function to delete the data
 Student::find($Nim)->delete();
 return redirect()->route('student.index')
 -> with('success', 'Student Successfully Deleted');
 }
 public function search(Request $request)
    {
        $search = $request->search;
        $student = DB::table('student')
        ->where('name','like',"%".$search."%");
        return view ('student.index', compact('student'));
    }
};
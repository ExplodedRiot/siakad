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
     $class = ClassModel::all(); //get data from all class table
     return view('student.create',['class' => $class])
 }
 public function store(Request $request)
 {

 //melakukan validasi data
 $request->validate([
 'Nim' => 'required',
 'Name' => 'required',
 'Class' => 'required',
 'Major' => 'required', 
 ]); 
 $student = new Mahasiswa;
 $student->nim = $request->get('Nim');
 $student->name = $request->get('Name');
 $student->major = $request->get('Major');
 $student->save();

 $class = new ClassModel;
 $class->id = $request->get('Class');
 // eloquent function to add data
$student->class()->associate($class);
$student->save();

return redirect()->route('student.index')
    ->with('success', 'Stdent successfully added');
 }
 public function show($Nim)
 {
 // displays detailed data by finding / by Student Nim
 $student = Student::with('class')->where('nim',$Nim)->first();

 return view('student.detail', ['Student' => $student]);
 }
 public function edit($Nim)
 {
// displays detail data by finding based on Student Nim for editing
 $student = Student::with('Class')->where('Nim', $Nim)->first();
 $class = Class::all(); //mendapatkan data dari tabel kelas
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

 $student = Student::with('Class')->where('Nim', $Nim)->first();
 $student->Nim = $request->get('Nim');
 $student->Name = $request->get('Name');
 $student->Major = $request->get('Major');
 $student->save();

 $class = new class;
 $class->id = $request->get('Class');

//Eloquent function to update the data
$student->class()->associate($class);
$student->save();

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
    public function print_pdf($nim)
    {
        $id = Mahasiswa::where('nim', $nim)->value('id_student');
        $student = student::with('class', 'course')
        ->where('nim', $nim)
        ->first();
        $pdf = PDF::loadview('student.course', ['Student'=> $student]);
        return $pdf->stream();
    }
};
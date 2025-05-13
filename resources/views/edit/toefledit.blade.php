@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
  <h2 class="text-2xl font-semibold mb-6">Edit Data Siswa TOEFL</h2>

  @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
  @endif

  <form action="{{ route('toefl.update', $student->id) }}" method="POST" class="max-w-lg">
    @csrf
    @method('PUT')

    {{-- Nama --}}
    <div class="mb-4">
      <label class="form-label">Nama</label>
      <input type="text" name="name"
             value="{{ old('name', $student->name) }}"
             class="form-control @error('name') is-invalid @enderror">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Class --}}
    <div class="mb-4">
      <label class="form-label">Class</label>
      <input type="text" name="class"
             value="{{ old('class', $student->class) }}"
             class="form-control @error('class') is-invalid @enderror">
      @error('class') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Email --}}
    <div class="mb-4">
      <label class="form-label">Email</label>
      <input type="email" name="email"
             value="{{ old('email', $student->email) }}"
             class="form-control @error('email') is-invalid @enderror">
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Gender --}}
    <div class="mb-4">
      <label class="form-label">Gender</label>
      <select name="gender" class="form-control @error('gender') is-invalid @enderror">
        <option value="M" {{ old('gender', $student->gender)=='M'?'selected':'' }}>M</option>
        <option value="F" {{ old('gender', $student->gender)=='F'?'selected':'' }}>F</option>
      </select>
      @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Nationality & Origin --}}
    <div class="mb-4">
      <label class="form-label">Country/Region of Nationality</label>
      <input type="text" name="country_region_nationality"
             value="{{ old('country_region_nationality', $student->country_region_nationality) }}"
             class="form-control @error('country_region_nationality') is-invalid @enderror">
      @error('country_region_nationality') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>
    <div class="mb-4">
      <label class="form-label">Country/Region of Origin</label>
      <input type="text" name="country_region_origin"
             value="{{ old('country_region_origin', $student->country_region_origin) }}"
             class="form-control @error('country_region_origin') is-invalid @enderror">
      @error('country_region_origin') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>

    {{-- Native Language --}}
    <div class="mb-4">
      <label class="form-label">Native Language</label>
      <input type="text" name="native_language"
             value="{{ old('native_language', $student->native_language) }}"
             class="form-control @error('native_language') is-invalid @enderror">
      @error('native_language') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>

    {{-- Date of Birth --}}
    <div class="mb-4">
      <label class="form-label">Date of Birth</label>
      <input type="date" name="date_of_birth"
             value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}"
             class="form-control @error('date_of_birth') is-invalid @enderror">
      @error('date_of_birth') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>

    {{-- School Name --}}
    <div class="mb-4">
      <label class="form-label">School Name</label>
      <input type="text" name="school_name"
             value="{{ old('school_name', $student->school_name) }}"
             class="form-control @error('school_name') is-invalid @enderror">
      @error('school_name') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>

    {{-- Exam Date --}}
    <div class="mb-4">
      <label class="form-label">Exam Date</label>
      <input type="date" name="exam_date"
             value="{{ old('exam_date', $student->exam_date->format('Y-m-d')) }}"
             class="form-control @error('exam_date') is-invalid @enderror">
      @error('exam_date') 
        <div class="invalid-feedback">{{ $message }}</div> 
      @enderror
    </div>

    {{-- Scores --}}
    <div class="row">
      @foreach(['reading','listening','speaking','writing'] as $section)
      <div class="col-md-3 mb-4">
        <label class="form-label">{{ ucfirst($section) }} Score</label>
        <input type="number" name="{{ $section }}_score"
               value="{{ old($section.'_score', $student->{$section.'_score'}) }}"
               class="form-control @error($section.'_score') is-invalid @enderror"
               min="0" required>
        @error($section.'_score')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Batal</a>
  </form>
</div>
@endsection

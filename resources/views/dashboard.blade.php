<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($courses as $course)
                <div class="wrapper">
                    <div class="pic" style="background: url('{{ url($course->image_url) }}') no-repeat;background-size: contain;"></div>
                    <p class="header">
                        {{ $course->title }}
                    </p>
                    <p class="content">{{ $course->description }}</p>
                    <a href="{{ route('courses.show', $course->id) }}" target="blank">
                        <div class="card__but view_course"><b>view course</b></div>
                    </a>
                    @if ( !$course->enrolled )
                        <form action="{{ route('course.enroll', ['course' => $course->id]) }}" method="POST" >
                            @csrf
                            <button class="card__but enroll_now" type="submit"  >
                                    <b>Enroll Now</b>
                            </button>
                        </form>
                    @else
                        @if (session('status') && $course->id == session('courseId') )
                            <button class="card__but enroll_now" type="submit"   disabled style="background-color: grey"  >
                                <b> {{session('status')}} </b>
                            </button>
                        @endif
                    @endif
                    
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

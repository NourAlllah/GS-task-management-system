<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="course_div">
                <img src="{{ asset($course->image_url) }}" alt="course" class="course_img">
                <h2 class="course_title">{{ $course->title }}</h2>
                <p class="course_description">{{ $course->description }}</p>
            </div>

            <strong class="course_lessons">course lessons</strong> 

            @foreach ($lessons as $lesson)
                <div class="lesson_div">
                    <div class="marg_ver_20">
                        <h4 class="lesson_title">
                            {{ $lesson->title }}
                        </h4>
                        <p class="lesson_description">
                            {{ $lesson->content }} ( {{ $course->title }} )
                        </p>
                    </div>
                    
                    @if ( $course->enrolled )
                        <form action="{{ route('lesson.watch', ['course' => $course->id, 'lesson' => $lesson->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="watch_button">Watch now</button>
                        </form>
                    @endif
                    
                </div>
            @endforeach
            
        </div>
    </div>
</x-app-layout>
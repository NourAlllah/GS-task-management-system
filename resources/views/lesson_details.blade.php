<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="course_div">
                    <h4 class="lesson_title">
                        {{ $lesson->title }}
                    </h4>
                    <p class="lesson_description">
                        {{ $lesson->content }} 
                    </p>
                </div>

                @if (session('status') !== null)
                    <div class="lesson_div">
                        {{ session('message') }}
                    </div> 
                @endif

                
                <form action="{{ route('comment.submit', [ 'lesson' => $lesson->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    <h2 class="share_title">Share with us:</h2>
                    <div class="input_comment">
                        <input type="text" placeholder="Your comments matter..." name="comment" required>
                    </div>   
                    <button type="submit" class="submit_comment">Submit comment</button>

                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </form>


                @foreach ($comments as $comment)
                    <div class="comments">
                        <div class="comment_body">
                            <p>
                                <div class="replied_to">
                                    <p>
                                        <span class="user">{{$comment->user->name}}</span>
                                        {{$comment->content}}
                                    </p>
                                </div>
                            </p>
                        </div>
                    </div>
                @endforeach
                

                         
                
        </div>
    </div>
</x-app-layout>
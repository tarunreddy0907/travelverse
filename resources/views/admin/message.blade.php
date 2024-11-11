@extends('layouts/admin-layouts/main-structure')

@section('admincontent')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-5 border-bottom">
        <h2 class="fw-light">Messages</h2>
    </div>
    <div class="container">
        {{-- To display validation errors or success messages --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="fw-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <li class="fw-light">try again</li>
            </ul>
        </div>
        @endif
  
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif     
                  

        <table class="table">
            <thead>
            <tr class="table-dark">
                <th scope="col">No &nbsp;&nbsp;&nbsp;&nbsp;  message</th>  
                <th scope="col" style="width: 50%;"> </th>  
                <th></th><th></th>         
            </tr>
            </thead>
        </table>
        
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @if ($user_messages->isNotEmpty())
                @foreach ($user_messages as $key => $message)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading{{ $key }}">
                            <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false" aria-controls="flush-collapse{{ $key }}">
                                <div class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="me-3 fw-bold">{{ $message->id }}.</span>
                                    <span class="flex-grow-1 text-start fw-bold">{{ $message->subject }}</span>
                                    <span class="me-5">{{ \Carbon\Carbon::parse($message->created_at)->format('d M,Y | h:i A') }}</span>
                                </div>
                            </button>                       
                        </h2>
                        <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $key }}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body ">
                                <div class="message-box-main">
                                    <ul>
                                        <li class="fw-medium">{{ $message->user_name }}</li>
                                        <li class="fw-light">{{ $message->email }}</li>
                                        <li class="fw-medium"><pre>{{ \Carbon\Carbon::parse($message->created_at)->format('d M,Y | h:i A') }}</pre></li>
                                        <li class="fw-medium">message : </li>
                                        <div class="message-box mt-1 p-4">
                                            <li><strong><q>{{ $message->discription }}</q></strong></li>
                                        </div>
                                        <li class="mt-4">
                                            <a href="mailto:{{$message->email}}" type="button" class="btn btn-success btn-sm">Send Email</a>
                                            {{-- button for delete the blog post --}}
                                            <a href="#" onclick="deleteUsermessage({{ $message->id}});" class="btn btn-danger btn-sm">Delete</a>
                                            <form id="message-id-{{ $message->id }}" action="{{route('admin.message.delete', $message->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div> <br>
                @endforeach
            @endif
        </div>
    </div>

    {{-- script for delete blog post cofomation alert --}}
    <script>
        function deleteUsermessage(id){
        if(confirm("Do you want to this message ?")){
            document.getElementById('message-id-' + id).submit();
        }
        }
    </script>

</main>
@endsection

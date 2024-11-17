<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-6 flex justify-between items-center">
                        <!-- Add your button here -->
                        <x-primary-button class="ms-3" >
                            <a href="{{route('view.add-post')}}"> Add New Posts </a>
                        </x-primary-button>
                        
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Full-Width Table -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">User Information</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Content</th>
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Author</th>
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Created On</th>
                                        <th class="border border-gray-200 px-4 py-2 text-left text-sm font-medium text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0;  @endphp
                                    @foreach( $posts as $val )
                                    @php $i++;  @endphp
                                    <tr>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> {{$i}} </td>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> {{$val['title']}} </td>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> {{$val['content']}} </td>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> {{$val['author']}} </td>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> {{ date('d M Y, h:i A', strtotime($val['created_at'])) }} </td>
                                        <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800"> 
                                            <a href="{{ route('view.edit-post', $val['id']) }}" class="text-blue-500 hover:text-blue-700 px-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('delete.post', $val['id']) }}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if(count($posts) == 0)
                                        <tr>
                                            <td class="border border-gray-200 px-4 py-2 text-sm text-gray-800 text-center" colspan="6"> No Data Found </td>
                                        </tr>
                                    @endif  
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

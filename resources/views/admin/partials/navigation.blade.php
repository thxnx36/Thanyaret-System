<!-- Admin Navigation Menu -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6" data-aos="fade-up" data-aos-delay="50">
    <a href="{{ route('admin.dashboard') }}" 
       class="bg-indigo-{{ $active === 'dashboard' ? '100 shadow-md border-2 border-indigo-300' : '50 hover:bg-indigo-100 shadow-sm hover:shadow-md' }} rounded-lg p-3 flex items-center transition-colors duration-200">
        <div class="bg-indigo-{{ $active === 'dashboard' ? '200' : '100' }} p-2 rounded-full mr-3">
            <i class="fas fa-tachometer-alt text-indigo-600"></i>
        </div>
        <span class="font-medium text-gray-800">Dashboard</span>
    </a>
    
    <a href="{{ route('admin.users') }}" 
       class="bg-blue-{{ $active === 'users' ? '100 shadow-md border-2 border-blue-300' : '50 hover:bg-blue-100 shadow-sm hover:shadow-md' }} rounded-lg p-3 flex items-center transition-colors duration-200">
        <div class="bg-blue-{{ $active === 'users' ? '200' : '100' }} p-2 rounded-full mr-3">
            <i class="fas fa-users text-blue-600"></i>
        </div>
        <span class="font-medium text-gray-800">Manage Users</span>
    </a>
    
    <a href="{{ route('admin.topics') }}" 
       class="bg-green-{{ $active === 'topics' ? '100 shadow-md border-2 border-green-300' : '50 hover:bg-green-100 shadow-sm hover:shadow-md' }} rounded-lg p-3 flex items-center transition-colors duration-200">
        <div class="bg-green-{{ $active === 'topics' ? '200' : '100' }} p-2 rounded-full mr-3">
            <i class="fas fa-comments text-green-600"></i>
        </div>
        <span class="font-medium text-gray-800">Manage Topics</span>
    </a>
    
    <a href="{{ route('admin.comments') }}" 
       class="bg-amber-{{ $active === 'comments' ? '100 shadow-md border-2 border-amber-300' : '50 hover:bg-amber-100 shadow-sm hover:shadow-md' }} rounded-lg p-3 flex items-center transition-colors duration-200">
        <div class="bg-amber-{{ $active === 'comments' ? '200' : '100' }} p-2 rounded-full mr-3">
            <i class="fas fa-comment-dots text-amber-600"></i>
        </div>
        <span class="font-medium text-gray-800">Manage Comments</span>
    </a>
</div> 
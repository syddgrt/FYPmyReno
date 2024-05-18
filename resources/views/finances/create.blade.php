<!-- resources/views/finances/create.blade.php -->

<form action="{{ route('finances.store') }}" method="POST">
    @csrf
    <div>
        <label for="project_id">Project:</label>
        <select name="project_id" id="project_id">
            @foreach($projects as $id => $title)
                <option value="{{ $id }}">{{ $title }}</option>
            @endforeach
        </select>
    </div>
    <!-- Add other input fields for financial data here -->
    <button type="submit">Submit</button>
</form>

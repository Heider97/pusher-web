<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queued Jobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Queued Jobs</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Queue</th>
                    <th class="py-2 px-4 border">Payload</th>
                    <th class="py-2 px-4 border">Attempts</th>
                    <th class="py-2 px-4 border">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr class="border">
                        <td class="py-2 px-4 border">{{ $job->id }}</td>
                        <td class="py-2 px-4 border">{{ $job->queue }}</td>
                        <td class="py-2 px-4 border truncate max-w-xs">{{ Str::limit($job->payload, 50) }}</td>
                        <td class="py-2 px-4 border text-center">{{ $job->attempts }}</td>
                        <td class="py-2 px-4 border">{{ $job->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-4 text-gray-600">Total Jobs: {{ count($jobs) }}</p>
    </div>
</body>
</html>
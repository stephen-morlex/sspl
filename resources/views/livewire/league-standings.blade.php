<div>
    <div class="mb-4">
        <label for="league" class="block text-sm font-medium text-gray-700">Select League</label>
        <select wire:model="leagueId" id="league" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @foreach($leagues as $league)
                <option value="{{ $league->id }}">{{ $league->name }}</option>
            @endforeach
        </select>
    </div>
    
    @if($standings->isNotEmpty())
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">P</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">W</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">D</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">L</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GF</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GA</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GD</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pts</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($standings as $standing)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $standing->position }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->team->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->played }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->won }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->drawn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->lost }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->goals_for }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->goals_against }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $standing->goal_difference }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $standing->points }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No standings available for the selected league.</p>
    @endif
</div>

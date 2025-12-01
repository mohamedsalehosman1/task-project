<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">{{ __('Latest Donations') }}</h4>

        <div class="table-responsive">
            <table class="table table-centered">
                <thead>
                    <tr>
                        <th scope="col">{{ __("Date") }}</th>
                        <th scope="col">{{ __("Donor Name") }}</th>
                        <th scope="col">{{ __("Amount") }}</th>
                        <th scope="col" colspan="2">{{ __("Donation Type") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donations as $donation)
                        <tr>
                            <td>{{ $donation->paid_at }}</td>
                            <td>{{ $donation->donor->name }}</td>
                            <td>$ 125</td>
                            <td>
                                @if ($donation->type == 'online')
                                    <span class="badge badge-soft-success font-size-12">{{ $donation->type }}</span>
                                @else
                                <span class="badge badge-soft-danger font-size-12">{{ $donation->type }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dashboard.donations.show', $donation) }}" class="btn btn-primary btn-sm">{{ __("View") }}</a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <ul class="pagination pagination-rounded justify-content-center mb-0">
                {{ $donations->links() }}
            </ul>
        </div>
    </div>
</div>

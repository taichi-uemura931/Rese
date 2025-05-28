@extends('layouts.app')

@section('title', '予約一覧')

<link rel="stylesheet" href="{{ asset('css/owner_reservations.css') }}">

@section('content')
<div class="reservation-container">
    <div class="title-group">
        <a href="{{ route('owner.dashboard') }}" class="back-btn">&lt;</a>
        <h2 class="reservation-title">自店舗への予約一覧</h2>
    </div>

    @if($reservations->isEmpty())
        <p class="no-reservation-message">現在予約はありません。</p>
    @else
        <div class="table-wrapper">
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>予約者</th>
                        <th>店舗名</th>
                        <th>日付</th>
                        <th>時間</th>
                        <th>人数</th>
                        <th>状態</th>
                        <th>来店</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->restaurant->name }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>{{ $reservation->number_of_people }}人</td>
                            <td>
                                @if ($reservation->canceled)
                                    <span class="badge cancel">キャンセル済み</span>
                                @else
                                    <form action="{{ route('owner.reservations.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('本当にキャンセルしますか？')">
                                        @csrf
                                        <button type="submit" class="btn cancel-btn">キャンセル</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('owner.reservations.toggleVisited', $reservation->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="btn toggle-visited-btn {{ $reservation->visited ? 'visited' : 'not-visited' }}"
                                        data-id="{{ $reservation->id }}"
                                        data-visited="{{ $reservation->visited ? '1' : '0' }}"
                                    >
                                        {{ $reservation->visited ? '来店済み' : '未来店' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-visited-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const reservationId = button.dataset.id;

            try {
                const response = await fetch(`/owner/reservations/${reservationId}/visited-toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) return;

                const isVisited = button.dataset.visited === '1';
                button.dataset.visited = isVisited ? '0' : '1';
                button.textContent = isVisited ? '未来店' : '来店済み';

                button.classList.toggle('visited');
                button.classList.toggle('not-visited');

            } catch (e) {
                console.error('通信失敗:', e);
            }
        });
    });
});
</script>


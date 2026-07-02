@auth
    <script>
        (function () {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            if (!timezone) {
                return;
            }

            const storedTimezone = @json(auth()->user()->timezone);
            if (storedTimezone === timezone) {
                return;
            }

            fetch(@json(filament()->getCurrentPanel()->route('sync-timezone')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
                body: JSON.stringify({ timezone }),
                credentials: 'same-origin',
            }).then(function (response) {
                if (response.ok) {
                    window.location.reload();
                }
            });
        })();
    </script>
@endauth

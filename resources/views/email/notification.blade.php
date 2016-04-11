<h1>Notifikácia</h1>
<table>
    <thead>
        <tr>
            <th>Kto</th>
            <th>Kedy</th>
            <th>Čo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $notification->user->name }}
            </td>
            <td>
                {{ $notification->created_at }}
            </td>
            <td>
                {{ $notification->type }}: {{ $notification->task->name }}
            </td>
        </tr>
    </tbody>
</table>

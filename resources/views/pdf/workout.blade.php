<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h1>TrainSys</h1>
    <h3> Treinos do Estudante - {{ $student->name }}</h3>

    <table>
        <thead>
            <tr>
                <th>Dia</th>
                <th>Exercício</th>
                <th>Repetições</th>
                <th>Peso</th>
                <th>Tempo</th>
                <th>Descanso</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($workouts as $workout)
                <tr>
                    <td>{{ $workout->day }}</td>
                    <td>{{ optional($workout->exercise)->description }}</td>
                    <td>{{ $workout->repetitions }}</td>
                    <td>{{ $workout->weight }}Kg</td>
                    <td>{{ $workout->time }}</td>
                    <td>{{ $workout->break_time }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #3faaec;
        padding: 10px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #000000;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #e7e6e6;
    }
</style>

</html>

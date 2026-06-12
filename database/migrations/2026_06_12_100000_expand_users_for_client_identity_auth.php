<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identificacion', 13)->nullable()->after('cedula');
            $table->string('identificacion_canonica', 13)->nullable()->after('identificacion');
            $table->string('nombres')->nullable()->after('name');
            $table->string('apellidos')->nullable()->after('nombres');
            $table->text('direccion')->nullable()->after('phone');
            $table->unsignedBigInteger('sgn_cliente_id')->nullable()->after('direccion');
        });

        DB::table('users')
            ->orderBy('id')
            ->get()
            ->each(function (object $user): void {
                $identificacion = $this->normalize($user->cedula ?? '');
                [$nombres, $apellidos] = $this->splitFullName($user->name ?? '');

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'identificacion' => $identificacion !== '' ? $identificacion : null,
                        'identificacion_canonica' => $identificacion !== '' ? $this->canonicalize($identificacion) : null,
                        'nombres' => $nombres !== '' ? $nombres : null,
                        'apellidos' => $apellidos !== '' ? $apellidos : null,
                    ]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->unique('identificacion_canonica');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['identificacion_canonica']);
            $table->dropColumn([
                'identificacion',
                'identificacion_canonica',
                'nombres',
                'apellidos',
                'direccion',
                'sgn_cliente_id',
            ]);
        });
    }

    protected function normalize(string $value): string
    {
        return preg_replace('/\D+/', '', trim($value)) ?? '';
    }

    protected function canonicalize(string $value): string
    {
        $normalized = $this->normalize($value);

        if (strlen($normalized) === 13 && str_ends_with($normalized, '001')) {
            return substr($normalized, 0, 10);
        }

        return $normalized;
    }

    protected function splitFullName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $parts = array_values(array_filter($parts, fn (string $part) => $part !== ''));
        $count = count($parts);

        if ($count === 0) {
            return ['', ''];
        }

        if ($count === 1) {
            return [$parts[0], ''];
        }

        $middle = (int) ceil($count / 2);

        return [
            implode(' ', array_slice($parts, 0, $middle)),
            implode(' ', array_slice($parts, $middle)),
        ];
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherReport extends Model
{
    use HasFactory;


    protected $table = 'weather_reports';
    protected $primaryKey = 'wrID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'locID',
        'report_date',
    ];


    public function location()
    {
        return $this->belongsTo(Location::class, 'locID', 'locID');
    }


    public function snapshots()
    {
        return $this->hasMany(Snapshot::class, 'wrID', 'wrID');
    }

    public static function forLocationAndDate(int $locID, string $date): self
    {
        static::removeDuplicateRows($locID, $date);

        $report = static::firstOrCreate([
            'locID' => $locID,
            'report_date' => $date,
        ]);

        Snapshot::removeDuplicateRows($report->wrID);

        return $report;
    }

    public static function removeDuplicateRows(?int $locID = null, ?string $date = null): int
    {
        $query = static::query()
            ->select('locID', 'report_date')
            ->groupBy('locID', 'report_date')
            ->havingRaw('COUNT(*) > 1');

        if ($locID) {
            $query->where('locID', $locID);
        }

        if ($date) {
            $query->where('report_date', $date);
        }

        $deleted = 0;

        foreach ($query->get() as $group) {
            $deleted += static::mergeRowsForLocationDate((int) $group->locID, (string) $group->report_date);
        }

        return $deleted;
    }

    private static function mergeRowsForLocationDate(int $locID, string $date): int
    {
        $reports = static::where('locID', $locID)
            ->where('report_date', $date)
            ->orderBy('wrID')
            ->get();

        if ($reports->count() <= 1) {
            $report = $reports->first();

            if ($report) {
                Snapshot::removeDuplicateRows($report->wrID);
            }

            return 0;
        }

        $keeper = $reports->shift();
        $deleted = 0;

        foreach ($reports as $report) {
            Snapshot::where('wrID', $report->wrID)->update(['wrID' => $keeper->wrID]);
            $report->delete();
            $deleted++;
        }

        Snapshot::removeDuplicateRows($keeper->wrID);

        return $deleted;
    }
}

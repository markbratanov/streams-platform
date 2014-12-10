<?php namespace Anomaly\Streams\Platform\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApplicationModel extends Model
{

    /**
     * Find an application record by domain.
     *
     * @param $domain
     * @return mixed
     */
    public function findByDomain($domain)
    {
        $domain = trim(str_replace(array('http://', 'https://'), '', $domain), '/');

        return DB::table('applications')
            ->leftJoin('applications_domains', 'applications.id', '=', 'applications_domains.application_id')
            ->where('applications.domain', $domain)
            ->orWhere('applications_domains.domain', $domain)
            ->first();
    }
}
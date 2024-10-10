<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoicesFilter  extends ApiFilter{

    $table->integer('customer_id');
    $table->integer('amount');
    $table->string('status');
    $table->dateTime('billed_date');
    $table->dateTime('paid_date')->nullable();
    protected $allowedParams = [
        'customer_id' => ['eq'],
        'amount' => ['eq'],
        'status' => ['eq'],
        'billed_date' => ['eq'],
        'paid_date' => ['eq'],
        
    ];

    protected $columnMap = [
        'customer_id' => 'postal_code',
        'billed_date' => 'postal_code',
        'paid_date' => 'postal_code',
    ];

    protected $operatorMap = [
        'eq'  => '=',
        'lt'  => '<',
        'lte' => '<=',
        'gt'  => '>',
        'gte' => '>='
    ];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach ($this->allowedParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}

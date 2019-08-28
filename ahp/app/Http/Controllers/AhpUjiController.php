<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Alternative;
use App\Http\Models\Criteria;
use App\Http\Models\PairwiseComparison;
use Auth;

class AhpUjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i = 0;
        $criterias = Criteria::where('group_criteria', '=', null)->get();

        $criterias_group = array();
        $total_criterias = 0;

        foreach ($criterias as $criteria) {
            $criterias_group[$criteria->id]["group"] = $criteria;
            $criterias_group[$criteria->id]["data"] = array();

            $subcriterias = Criteria::where('group_criteria', '=', $criteria->id)
                                    ->orderBy('id','DESC')
                                    ->get();
            
            if (count($subcriterias) == 0) {
                $criteria->global_weight = number_format($criteria->partial_weight, 3);
                $criteria->save();
            }

            foreach ($subcriterias as $subcriteria) {
                $subcriteria->global_weight = number_format($criteria->partial_weight * $subcriteria->partial_weight, 3);
                $subcriteria->save();
                $criterias_group[$criteria->id]["data"][] = $subcriteria;
            }
        }

        $bobotGlobalMap = $this->generateBobotGlobalMap($criterias_group);
        $dataAlternatives = $this->getDataAlternatives();
        $alternativesComparissonMatrixMap = $this->generateAlternativesComparissonMatrixMap( $bobotGlobalMap, $dataAlternatives );
        $normalizedAlternativesComparissonMatrixMap = $this->generateNormalizedAlternativesComparissonMatrixMap( $alternativesComparissonMatrixMap );
        $bobotAlternativesPerCriteriaMap = $this->generateBobotAlternativesPerCriteriaMap( $normalizedAlternativesComparissonMatrixMap );
        $globalAlternativesPriorityMap = $this->generateGlobalAlternativesPriorityMap( $bobotAlternativesPerCriteriaMap, $bobotGlobalMap );

        $sortedGlobalAlternativesPriorityMap = $globalAlternativesPriorityMap;
        rsort($sortedGlobalAlternativesPriorityMap);

        return view('ahpuji.index',compact('globalAlternativesPriorityMap', 'sortedGlobalAlternativesPriorityMap'));
    }

    function generateBobotGlobalMap( $criterias_group ){
        foreach($criterias_group as $obj){
            $criterias = $obj['data'];
            foreach($criterias as $criteria){
                $hashMap[ $criteria->name ] = $criteria->global_weight;
            }
        }

        // convert to standard criteria key
        $bobotGlobalMap['KK'] = $hashMap['Keterampilan komunikasi (KK)'];
        $bobotGlobalMap['KJ'] = $hashMap['Kejujuran (KJ)'];
        $bobotGlobalMap['KB'] = $hashMap['Kesan baik (KB)'];
        $bobotGlobalMap['KS'] = $hashMap['Kesungguhan (KS)'];
        $bobotGlobalMap['IK'] = $hashMap['Intensitas keikutsertaan pelatihan di BLK Bantul (IK)'];
        $bobotGlobalMap['KT'] = $hashMap['Keterampilan teknis (KT)'];
        $bobotGlobalMap['KO'] = $hashMap['Komitmen (KO)'];
        $bobotGlobalMap['ME'] = $hashMap['Mental (ME)'];
        $bobotGlobalMap['MO'] = $hashMap['Motivasi (MO)'];
        $bobotGlobalMap['PM'] = $hashMap['Penampilan (PM)'];
        $bobotGlobalMap['PT'] = $hashMap['Pendidikan terakhir (PT)'];
        $bobotGlobalMap['PP'] = $hashMap['Pengalaman pelatihan (PP)'];
        $bobotGlobalMap['PG'] = $hashMap['Pengetahuan (PG)'];
        $bobotGlobalMap['PD'] = $hashMap['Percaya diri (PD)'];
        $bobotGlobalMap['PE'] = $hashMap['Pertimbangan ekonomi (PE)'];
        $bobotGlobalMap['PK'] = $hashMap['Pertimbangan keluarga (PK)'];
        $bobotGlobalMap['PO'] = $hashMap['Potensi (PO)'];
        $bobotGlobalMap['RK'] = $hashMap['Rekomendasi (RK)'];
        $bobotGlobalMap['RS'] = $hashMap['Rencana setelah selesai pelatihan (RS)'];
        $bobotGlobalMap['SI'] = $hashMap['Sikap (SI)'];
        $bobotGlobalMap['US'] = $hashMap['Usia (US)'];
        
        return $bobotGlobalMap;
    }

    function getDataAlternatives(){
        $alternatives = Alternative::all();

        // convert to standard criteria key
        foreach($alternatives as $alternative){
            $alternativeCriteriaMap[ $alternative->name ] = $this->generateAlternativeCriteriaMap( $alternative );
        }

        return $this->generateConvertedAlternativeCriteriaMap( $alternativeCriteriaMap ); 
    }

    function generateAlternativeCriteriaMap( $alternative ){
        $alternativeCriteriaMap['KK'] = $alternative['communication_value'];
        $alternativeCriteriaMap['KJ'] = $alternative['honesty_value'];
        $alternativeCriteriaMap['KB'] = $alternative['impression_value'];
        $alternativeCriteriaMap['KS'] = $alternative['seriousness_value'];
        $alternativeCriteriaMap['IK'] = $alternative['intensity_participation'];
        $alternativeCriteriaMap['KT'] = $alternative['technical_value'];
        $alternativeCriteriaMap['KO'] = $alternative['commitment_value'];
        $alternativeCriteriaMap['ME'] = $alternative['mental_value'];
        $alternativeCriteriaMap['MO'] = $alternative['motivation_value'];
        $alternativeCriteriaMap['PM'] = $alternative['appearance_value'];
        $alternativeCriteriaMap['PT'] = $alternative['last_education'];
        $alternativeCriteriaMap['PP'] = $alternative['course_experience'];
        $alternativeCriteriaMap['PG'] = $alternative['knowledge_value'];
        $alternativeCriteriaMap['PD'] = $alternative['confidence_value'];
        $alternativeCriteriaMap['PE'] = $alternative['economic_value'];
        $alternativeCriteriaMap['PK'] = $alternative['family_value'];
        $alternativeCriteriaMap['PO'] = $alternative['potential_value'];
        $alternativeCriteriaMap['RK'] = $alternative['recommendation'];
        $alternativeCriteriaMap['RS'] = $alternative['orientation_value'];
        $alternativeCriteriaMap['SI'] = $alternative['attitude_value'];
        $alternativeCriteriaMap['US'] = $alternative['date_birth'];

        return $alternativeCriteriaMap;
    }

    function generateConvertedAlternativeCriteriaMap( $alternativeCriteriaMap ){
        foreach ($alternativeCriteriaMap as $key => $value){
            $convertedAlternativeCriteriaMap[ $key ] = $this->convertAlternativeToNumericValue( $value );
        }

        return $convertedAlternativeCriteriaMap;
    }

    function convertAlternativeToNumericValue( $alternativeValues ){
        $value = strtolower( $alternativeValues['KJ'] );
        $numericAlternativeValues[ 'KJ' ] = $value == 'Sesuai' ? 1 : 0.1;

        $key = 'SI';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'ME';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'PM';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'KK';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'PD';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'KS';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'KB';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == strtolower( 'Baik' ) ? 3 : ( $value == strtolower( 'Cukup' ) ? 2 : ( $value == strtolower( 'Kurang' ) ? 1 : 0.1 ) );

        $key = 'MO';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'kemauan sendiri' ? 2 : ( $value == 'dorongan orang lain' ? 1 : 0.1 );

        $key = 'PK';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'diijinkan' ? 2 : ( $value == 'tidak diijinkan' ? 1 : 0.1 );

        $key = 'PT';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'sma' || $value == 'smk' ? 4 : ( $value == 'smp' ? 3 : ( $value == 'sd ke bawah' || $value == 'sd' ? 2 : ( $value == 'diploma ke atas' ? 1 : 0.1 ) ) );

        $key = 'PE';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'kurang' ? 3 : ( $value == 'cukup' ? 2 : ( $value == 'mapan' ? 1 : 0.1 ) );

        $key = 'PO';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'berpotensi' ? 2 : ( $value == 'kurang berpotensi' ? 1 : 0.1 );

        $key = 'KO';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'sanggup' ? 2 : ( $value == 'ragu-ragu' ? 1 : 0.1 );

        $key = 'RK';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'ada' ? 2 : ( $value == 'tidak' ? 1 : 0.1 );

        $key = 'RS';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'membuka usaha' ? 3 : ( $value == 'melamar pekerjaan' ? 2 : ( $value == 'menambah ilmu/pengalaman/keterampilan' ? 1 : 0.1 ) );

        $key = 'PP';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'pernah ikut pelatihan di luar blk dan sesuai bidang yang diminati' ? 3 : ( $value == 'pernah ikut pelatihan di luar blk dan tidak sesuai bidang yang diminati' ? 2 : ( $value == 'belum pernah' ? 1 : 0.1 ) );

        $key = 'IK';
        $value = strtolower( $alternativeValues[$key] );
        $numericAlternativeValues[$key] = $value == 'belum pernah' ? 4 : ( $value == 'pernah ikut 1 kali' ? 3 : ( $value == 'pernah ikut 2 kali' ? 2 : ( $value == 'pernah ikut >= 3 kali' ? 1 : 0.1 ) ) );

        // usia
        $key = 'US';
        $birthDate = $alternativeValues[ $key ];
        $age = (date('Y') - date('Y',strtotime($birthDate)));
        $numericAlternativeValues[ $key ] = $age >= 41 ? 1 : ( $age >= 35 ? 2 : ( $age >= 26 ? 3 : ( $age >= 17 ? 4 : 0.1 ) ) );

        $key = 'KT';
        $value = $alternativeValues[ $key ];
        $numericAlternativeValues[ $key ] = $value > 0 ? $value : 0.1;

        $key = 'PG';
        $value = $alternativeValues[ $key ];
        $numericAlternativeValues[ $key ] = $value > 0 ? $value : 0.1;

        return $numericAlternativeValues;
    }

    function generateAlternativesComparissonMatrixMap( $bobotGlobalMap, $dataAlternatives ){
        foreach( $bobotGlobalMap as $criteria => $value ){
            $result[ $criteria ] = $this->generateComparissonMatrixPerCriteria($criteria,$dataAlternatives);
        }
        return $result;
    }

    function generateComparissonMatrixPerCriteria( $criteria, $dataAlternatives ){
        $result = array();
        foreach( $dataAlternatives as $namaPeserta1 => $alternatives1 ){
            $criteriaValue1 = $alternatives1[ $criteria ];

            $result[ $namaPeserta1 ] = array();
            foreach( $dataAlternatives as $namaPeserta2 => $alternatives2 ){
                $criteriaValue2 = $alternatives2[ $criteria ];
                $result[ $namaPeserta1 ][ $namaPeserta2 ] = $criteriaValue2 / $criteriaValue1;
            }
        }
        return $result;
    }

    function generateNormalizedAlternativesComparissonMatrixMap( $alternativesComparissonMatrixMap ){
        $result = array();
        foreach( $alternativesComparissonMatrixMap as $criteria => $alternativesComparissonMatrix ){
            $alternativesComparissonMatrixSum = $this->generateAlternativesComparissonMatrixSumMap( $alternativesComparissonMatrix );
            $result[ $criteria ] = $this->normalizeAlternativesComparissonMatrix( $alternativesComparissonMatrix, $alternativesComparissonMatrixSum );
        }

        return $result;
    }

    function generateAlternativesComparissonMatrixSumMap( $alternativesComparissonMatrix ){
        $result = array();
        foreach( $alternativesComparissonMatrix as $namaPeserta => $pesertaComparissonMatrix ){
            $total = 0;
            foreach( $pesertaComparissonMatrix as $value ){
                $total += $value;
            }

            $result[ $namaPeserta ] = $total;
        }
        return $result;
    }

    function normalizeAlternativesComparissonMatrix( $alternativesComparissonMatrix, $alternativesComparissonMatrixSum ){
        $result = array();
        foreach($alternativesComparissonMatrix as $namaPeserta1 => $pesertaComparissonMatrix){
            $result[ $namaPeserta1 ] = array();
            $sum = $alternativesComparissonMatrixSum[ $namaPeserta1 ];
            foreach( $pesertaComparissonMatrix as $namaPeserta2 => $value ){
                $result[ $namaPeserta1 ][ $namaPeserta2 ] = $value / $sum;
            }
        }
        return $result;
    }

    function generateBobotAlternativesPerCriteriaMap( $normalizedAlternativesComparissonMatrixMap ){
        $result = array();
        foreach($normalizedAlternativesComparissonMatrixMap as $criteria => $normalizedComparissonMatrixPerCriteria){
            $normalizedAlternativesComparissonMatrixSum = $this->generateNormalizedAlternativesComparissonMatrixHorizontalSumMap( $normalizedComparissonMatrixPerCriteria );
            $bobotGlobalPerCriteria = $this->calculateBobotGlobalPerCriteria( $normalizedAlternativesComparissonMatrixSum );
            $result[ $criteria ] = $bobotGlobalPerCriteria;
        }
        return $result;   
    }

    function generateNormalizedAlternativesComparissonMatrixHorizontalSumMap( $normalizedComparissonMatrixPerCriteria ){
        $result = array();
        foreach($normalizedComparissonMatrixPerCriteria as $pesertaComparissonMatrix){
            foreach($pesertaComparissonMatrix as $namaPeserta2 => $value){
                $result[ $namaPeserta2 ] = isset( $result[ $namaPeserta2 ] ) ? $result[ $namaPeserta2 ] + $value : $value;
            }
        }
        return $result;
    }

    function calculateBobotGlobalPerCriteria( $normalizedAlternativesComparissonMatrixSum ){
        $result = array();
        $arrayCount = count( $normalizedAlternativesComparissonMatrixSum );
        foreach( $normalizedAlternativesComparissonMatrixSum as $namaPeserta => $value ){
            $result[ $namaPeserta ] = $value / $arrayCount;
        }
        return $result;
    }


    function generateGlobalAlternativesPriorityMap( $bobotAlternativesPerCriteriaMap, $bobotGlobalMap ){
        $bobotAlternativesPerCriteriaMultipliedWithBobotGlobalMap = array();
        foreach( $bobotAlternativesPerCriteriaMap as $criteria => $bobotAlternativesPerCriteria ){
            $bobotAlternativesPerCriteriaMultipliedWithBobotGlobalMap[ $criteria ] = array();
            foreach( $bobotAlternativesPerCriteria as $namaPeserta => $value ){
                $bobotAlternativesPerCriteriaMultipliedWithBobotGlobalMap[ $criteria ][ $namaPeserta ] = number_format($value * $bobotGlobalMap[ $criteria ], 3);
            }
        }

        $globalAlternativesPriorityMap = array();
        foreach( $bobotAlternativesPerCriteriaMultipliedWithBobotGlobalMap as $criteria => $bobotAlternativesPerCriteriaMultipliedWithBobotGlobal ){
            foreach( $bobotAlternativesPerCriteriaMultipliedWithBobotGlobal as $namaPeserta => $value ){
                $globalAlternativesPriorityMap[ $namaPeserta ] = isset( $globalAlternativesPriorityMap[ $namaPeserta ] ) ? $globalAlternativesPriorityMap[ $namaPeserta ] + $value : $value;
            }
        }

        return $globalAlternativesPriorityMap;
    }
}
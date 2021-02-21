<template>
    <table class = "sheet" style = "width: 80%; margin: 0 auto; text-align: center" v-if = "hasInfo">
        <thead>
            <tr class = "sheet">
                <th class = "sheet"></th>
                <th v-for = "test in sheetInfo['tests']" class = "sheet" >{{ test['name'] }}</th>
                <th class = "sheet">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr class = "sheet">
                <td class = "sheet">MEAN</td>
                <td v-for = "test in sheetInfo['tests']">{{ stats[test['id']]['mean'] }}</td>
                <td class = "sheet">{{ stats['total']['mean'] }}</td>
            </tr>
            <tr class = "sheet">
                <td class = "sheet">MEDIAN</td>
                <td v-for = "test in sheetInfo['tests']">{{ stats[test['id']]['median'] }}</td>
                <td class = "sheet">{{ stats['total']['median'] }}</td>
            </tr>
            <tr class = "sheet">
                <td class = "sheet">STANDARD DEVIATION (s)</td>
                <td v-for = "test in sheetInfo['tests']">{{ stats[test['id']]['stddevSamp'] }}</td>
                <td class = "sheet">{{ stats['total']['stddevSamp'] }}</td>
            </tr>
            <tr class = "sheet">
                <td class = "sheet">STANDARD DEVIATION (σ)</td>
                <td v-for = "test in sheetInfo['tests']">{{ stats[test['id']]['stddevPop'] }}</td>
                <td class = "sheet">{{ stats['total']['stddevPop'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class = "container" v-else>
        <p class = "containerLabel">Spreadsheet Stats Unavailable:</p>
        <ul>
            <li class = "mainBoxText">You have not yet added any scores to this spreadsheet. Use the "edit" tab to do so.</li>
        </ul>
    </div>
</template>

<script>
//Stddev; sample is boolean for whether to use sample.
function stdDev (array, sample) {
    const n = array.length;
    const mean = array.reduce((a, b) => a + b) / n;
    const divisor = (sample ? n - 1 : n);

    return Math.sqrt(array.map(x => Math.pow(x - mean, 2)).reduce((a, b) => a + b) / divisor);
}

//Average linear speed median.
function quickselectMedian(arr) {
    const L = arr.length, halfL = L/2;
    if (L % 2 == 1)
        return quickselect(arr, halfL);
    else
        return 0.5 * (quickselect(arr, halfL - 1) + quickselect(arr, halfL));
}

function quickselect(arr, k) {
    // Select the kth element in arr
    // arr: List of numerics
    // k: Index
    // return: The kth element (in numerical order) of arr
    if (arr.length == 1)
        return arr[0];
    else {
        const pivot = arr[0];
        const lows = arr.filter((e)=>(e<pivot));
        const highs = arr.filter((e)=>(e>pivot));
        const pivots = arr.filter((e)=>(e==pivot));
        if (k < lows.length) // the pivot is too high
            return quickselect(lows, k);
        else if (k < lows.length + pivots.length)// We got lucky and guessed the median
            return pivot;
        else // the pivot is too low
            return quickselect(highs, k - lows.length - pivots.length);
    }
}

export default {
    name: "sheetStats",
    data() {
        return {
            //Will contain tests for this spreadsheet.
            sheetInfo: {},
            //Will contain stats of the various tests in form stats[testId][mean/median/stdev/σ] = value.
            stats: {},
            hasInfo: 0
        }
    },
    methods: {
        //Get SS info by making request to back end.
        getSheetInfo() {
            var sheetId = this.$route.params.id;
            axios.get('/spreadsheet/' + sheetId).then((response) => {
                this.sheetInfo = response.data

                //Values associated with each test.
                var testVals = {};
                //Holds all scores, allows tabulation of summary stats for entire dataset.
                var allScores = [];

                console.log(this.sheetInfo['spreadsheet_vals']);

                for(var i = 0; i < this.sheetInfo['spreadsheet_vals'].length; i++) {
                    var ssVal = this.sheetInfo['spreadsheet_vals'][i];

                    if (!isNaN(ssVal['value']) && ssVal['value'] !== null) {
                        allScores.push(Number(ssVal['value']));

                        try {
                            //Conditional filters out non-numeric values.
                            testVals[ssVal['testId']].push(Number(ssVal['value']));
                        } catch (err) {
                            testVals[ssVal['testId']] = [];
                            testVals[ssVal['testId']].push(Number(ssVal['value']));
                        }
                    }
                }

                for(var j = 0; j < this.sheetInfo['tests'].length; j++) {
                    let testId = this.sheetInfo['tests'][j]['id'];
                    let n = testVals[testId].length;
                    this.stats[testId] = {};

                    if(n != 0) {
                        this.stats[testId]['mean'] = (testVals[testId].reduce((a, b) => a + b) / n).toFixed(2);
                        this.stats[testId]['median'] = quickselectMedian(testVals[testId]).toFixed(2);
                        this.stats[testId]['stddevPop'] = stdDev(testVals[testId], 0).toFixed(2);
                        this.stats[testId]['stddevSamp'] = stdDev(testVals[testId], 1).toFixed(2);
                    } else {
                        this.stats[testId]['mean'] = '';
                        this.stats[testId]['median'] = '';
                        this.stats[testId]['stddevPop'] = '';
                        this.stats[testId]['stddevSamp'] = '';
                    }
                }

                if(allScores.length) {
                    //Get means of each measure across tests.
                    this.stats['total'] = {};

                    this.stats['total']['mean'] = (allScores.reduce((a, b) => a + b) / allScores.length).toFixed(2);
                    this.stats['total']['median'] = quickselectMedian(allScores).toFixed(2);
                    this.stats['total']['stddevPop'] = stdDev(allScores, 0).toFixed(2);
                    this.stats['total']['stddevSamp'] = stdDev(allScores, 1).toFixed(2);

                    //Used for whether or not to display table.
                    this.hasInfo = 1;
                }

            }).catch((errors) => {
                console.log(errors)
            });
        },
    },

    mounted() {
        this.getSheetInfo();
    }
}
</script>

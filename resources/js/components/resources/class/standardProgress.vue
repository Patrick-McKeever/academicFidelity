<template>
    <div v-if = "spreadsheets.length">
        <div v-for = "spreadsheet in spreadsheets">
            <div class = "container">
                <p class = "containerLabel">{{ spreadsheet['name'] }}</p>
                <ul class = "standardList" v-if = "spreadsheet['standards'].length">
                    <li v-for = "standard in JSON.parse(spreadsheet['standards'])">{{ standard }}</li>
                </ul>
                <ul class = "standardList" v-else>
                    <li>No standards input for this sheet as of yet.</li>
                </ul>
                <div class = "responseContainer" style = "text-align: center">
                    <canvas :id = "spreadsheet['id']"></canvas>
                </div>

                <div v-if = "chartUnavailable[spreadsheet['id']]">
                    <p class = "mainBoxText">No data input for this sheet.</p>
                </div>
            </div>
        </div>
    </div>

    <div class = "container" v-else>
        <p class = "containerLabel">Class Stats Unavailable:</p>
        <ul>
            <li class = "mainBoxText">You have not yet added any spreadsheets to this class yet.</li>
            <li class = "mainBoxText">To do so, go to the "spreadsheets" tab and use the blue plus button in the bottom right.</li>
        </ul>
    </div>
</template>

<script>
import Chart from 'chart.js';

export default {
    name: "standardProgress",
    data() {
        return {
            spreadsheets: [],
            //Object giving booleans of whether given sheet id doesn't have associated chart.
            // Of form chartUnavailable[sheetId] = bool.
            //If you think this can't be positive (e.g. whether sheet *does* have chart), it has to do
            //with chart.js rendering issues.
            chartUnavailable: {},
            charts: {}
        }
    },
    methods: {
        //Get sheet info, make charts for each sheet.
        getSpreadsheets() {
            var classId = this.$route.params.id;
            axios.get('/class/' + classId).then((response) => {
                this.spreadsheets = response.data['spreadsheets']

                for(var i = 0; i < this.spreadsheets.length; i++) {
                    var sheetId = this.spreadsheets[i]['id'];

                    //Query site backend again to get values associated with spreadsheet.
                    axios.get('/spreadsheet/' + sheetId).then((response) => {
                        var sheet = response.data;
                        var sheetId = sheet['id'];
                        var sheetVals = sheet['spreadsheet_vals'];

                        //Scores by test.
                        var testScores = {};

                        for (var j = 0; j < sheetVals.length; j++) {
                            var ssVal = sheetVals[j];

                            //Filter out non-numeric values.
                            if (!isNaN(ssVal['value']) && ssVal['value'] !== null) {
                                try {
                                    testScores[ssVal['testId']].push(Number(ssVal['value']));
                                } catch {
                                    testScores[ssVal['testId']] = [];
                                    testScores[ssVal['testId']].push(Number(ssVal['value']));
                                }
                            }
                        }

                        //Mean scores for each test of form meanScores[testId] = mean score.
                        var meanScores = [];
                        //Chart labels.
                        var labels = [];
                        //colors for each bar in chart.
                        var colors = [];

                        for (const testId in testScores) {
                            const n = testScores[testId].length;

                            if (n) {
                                var mean = testScores[testId].reduce((a, b) => a + b) / n;
                                meanScores.push(mean);

                                //Give green color for passing grade, red for non-passing.
                                var color = mean > 60 ? "#3D9970" : "#FF4136";
                                colors.push(color);

                                //Get test referenced by testId.
                                var test = sheet['tests'].filter(el => el['id'] == testId)[0];
                                labels.push(test['date']);
                            }
                        }

                        //Make chart for the given sheet.
                        if (meanScores.length) {
                            this.charts[sheetId] = new Chart(document.getElementById(sheetId), {
                                type: "bar",
                                data: {
                                    labels: labels,
                                    datasets: [
                                        {
                                            backgroundColor: colors,
                                            data: meanScores
                                        }
                                    ]
                                },
                                options: {
                                    legend: {display: false},
                                    title: {
                                        display: true,
                                        text: "SCORES OVER TIME"
                                    },
                                    scales: {
                                        yAxes: [{
                                            display: true,
                                            ticks: {
                                                min: 0,
                                                beginAtZero: true,
                                                max: 100
                                            }
                                        }]
                                    }
                                }
                            });
                        } else {
                            //Since we made chart for this sheet, we'll indicate that in an attribute.
                            //That way, we can return "no data in sheet" for sheets that don't have data.
                            this.chartUnavailable[sheetId] = true;
                        }
                    }).catch((errors) => {
                        console.log(errors);
                    });
                }
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getSpreadsheets()
    }
}
</script>

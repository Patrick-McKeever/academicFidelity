<template>
    <div class = "container">
        <p class = "mainBoxText"><b>Select Standard to See Group's Learning Progress</b></p>
        <div class = "form-group" v-if = "standards.length">
            <div class = "floating-label">
                <select v-model = "selectedStandard" @change = "makeGraphs()" class = "floating-select">
                    <option disabled selected></option>
                    <option v-for = "standard in standards" :value = "standard">{{ standard }}</option>
                </select>
                <label class = "float">Select Standard</label>
            </div>

            <div class = "responseContainer" style = "text-align: center">
                <canvas id = "chart"></canvas>
            </div>
        </div>

        <div v-else>
            <ul>
                <li class = "mainBoxText">No standards yet added to sheets within classes shared to this group.</li>
            </ul>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js";

export default {
    name: "groupQuery",
    data() {
        return {
            spreadsheets: [],
            //Set of standards in spreadsheets in classes shared with group.
            standards: new Set(),
            selectedStandard: null,
            scores: {},
            sheetsWithStandard: [],
            chartSettings: {
                data: [],
                labels: [],
                colors: []
            },
            chartInst: null
        }
    },
    methods: {
        //Gets standards in sheets in classes shared with group.
        getInfo() {
            var groupId = this.$route.params.id;

            //Get shared class ids.
            axios.get('/sharedClass/' + groupId).then((response) => {
                var sharedClasses = response.data

                //Get classinfo for each class.
                for(var i = 0; i < sharedClasses.length; i++) {
                    var classId = sharedClasses[i]['id'];

                    axios.get('/class/' + classId).then((response) => {
                        var spreadsheets = response.data['spreadsheets'];

                        //Add sheet standards to set of standards.
                        for(var j = 0; j < spreadsheets.length; j++) {
                            axios.get('/spreadsheet/' + spreadsheets[j]['id']).then((response) => {
                                this.spreadsheets.push(response.data)
                            }).catch((errors) => {
                                console.log(errors);
                            });

                            var sheetStandards = JSON.parse(spreadsheets[j]['standards']);

                            for(var k = 0; k < sheetStandards.length; k++) {
                                this.standards.add(sheetStandards[k]);
                            }
                        }

                        //Because v-for doesn't work with sets.
                        this.standards = Array.from(this.standards);
                    }).catch((errors) => {
                        console.log(errors)
                    });
                }
            }).catch((errors) => {
                console.log(errors)
            });
        },
        //Actually fill in the graphs.
        generateCharts() {
            for(const date in this.scores) {
                var n = this.scores[date].length;

                if (n) {
                    var mean = this.scores[date].reduce((a, b) => a + b) / n;

                    this.chartSettings['data'].push(mean);
                    this.chartSettings['labels'].push(date);
                    //Green for passing mean score, red for failing.
                    this.chartSettings['colors'].push(mean > 60 ? "#3D9970" : "#FF4136");
                }
            }

            if(this.chartSettings['data'].length) {
                this.chartInst = new Chart(document.getElementById('chart'), {
                    type: "bar",
                    data: {
                        labels: this.chartSettings['labels'],
                        datasets: [
                            {
                                backgroundColor: this.chartSettings['colors'],
                                data: this.chartSettings['data']
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
            }
        },
        //get test scores from each spreadsheet with standard, make graphs of progress.
        makeGraphs() {
            //Reset attrs.
            this.sheetsWithStandard = [];
            this.scores = {};

            //List of sheets that have the standard selected by user.
            this.sheetsWithStandard = this.spreadsheets.filter(spreadsheet =>
                spreadsheet['standards'].includes(this.selectedStandard));

            var benchmarks = {};

            //1) Get a list of test dates.
            //2) For every date, average out the most recent test score average of each class, weighted by number of students.
            for(var i = 0; i < this.sheetsWithStandard.length; i++) {
                var spreadsheet = this.sheetsWithStandard[i];

                for(var j = 0; j < spreadsheet['tests'].length; j++) {
                    var test = spreadsheet['tests'][j];
                    benchmarks[test['date']] = [];
                }
            }

            var bmDates = Object.keys(benchmarks).sort();

            for(var k = 0; k < bmDates.length; k++) {
                var bmDate = bmDates[k];

                //get most recent test in each sheet before each benchmark date.
                //This way, every time the average value of all scores in all sheets changes,
                //we can calculate the average among all sheets.
                for(var i = 0; i < this.sheetsWithStandard.length; i++) {
                    var spreadsheet = this.sheetsWithStandard[i];

                    for(var j = 0; j < spreadsheet['tests'].length; j++) {
                        var test = spreadsheet['tests'][j];

                        if(test['date'] <= bmDate) {
                            var mostRecent = test;
                        }
                    }

                    if(typeof mostRecent !== 'undefined') {
                        benchmarks[bmDate].push(mostRecent);
                        mostRecent = undefined;
                    }
                }
            }

            var dates = Object.keys(benchmarks).sort();
            console.log(dates);
            console.log('dates');
            //Calculate average, chart settings.
            for(var k = 0; k < dates.length; k++) {
                let date = dates[k];
                var testList = benchmarks[date];
                this.scores[date] = [];

                for(var i = 0; i < testList.length; i++) {
                    var test = testList[i];

                    axios.get('/test/' + test['id']).then((response) => {
                       var test = response.data;

                        var newScores = test['spreadsheet_value'].map(val => parseInt(val['value']))
                            .filter(Boolean);
                        console.log(date)
                        this.scores[date] = this.scores[date].concat(newScores);
                    }).catch((error) => {
                        console.log(error)
                    });
                }
            }

            setTimeout(this.generateCharts, 500);
        }
    },
    mounted() {
        this.getInfo();
    }
}
</script>

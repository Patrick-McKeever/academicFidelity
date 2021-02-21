<template>
    <div v-if = "Object.keys(values).length">
        <div v-for = "(spreadsheet, sheetId) in values">
            <div class = "container">
                <p class = "containerLabel">{{ spreadsheet['name'] }}</p>
                <ul class = "standardList" v-if = "JSON.parse(spreadsheet['standards']).length">
                    <li v-for = "standard in JSON.parse(spreadsheet['standards'])">{{ standard }}</li>
                </ul>
                <ul class = "standardList" v-else>
                    <li>No standards input for this sheet as of yet.</li>
                </ul>
                <div class = "responseContainer" style = "text-align: center">
                    <canvas id = "chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class = "container" v-else>
        <p class = "containerLabel">Unavailable</p>
        <ul>
            <li class = "mainBoxText">No scores for this user yet.</li>
        </ul>
    </div>
</template>

<script>
import Chart from 'chart.js';

export default {
    name: "studentPerformance",
    data() {
        return {
            //Chart instances.
            charts: [],
            //User test scores.
            values: {
                sheetId: {
                    standards: '[]',
                    name: '',
                    scores: {}
                }
            }
        }
    },
    methods: {
        //Get user test scores from back end.
        getValues() {
            var memberId = this.$route.params.id;

            axios.get('/classMember/' + memberId + '/performance').then((response) => {
                this.values = response.data

                for(let sheetId in this.values) {
                    this.charts[sheetId] = new Chart(document.getElementById('chart'), {
                        type: "bar",
                        data: {
                            labels: Object.keys(this.values[sheetId]['scores']),
                            datasets: [
                                {
                                    //Green for passing, red for fail
                                    backgroundColor: Object.values(this.values[sheetId]['scores']).map(
                                        score => Number(score) > 60 ? "#3D9970" : "#FF4136"
                                    ),
                                    data: Object.values(this.values[sheetId]['scores']).map(Number)
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
            }).catch((errors) => {
                console.log(errors)
            });
        }
    },
    mounted() {
        this.getValues()
    }
}
</script>

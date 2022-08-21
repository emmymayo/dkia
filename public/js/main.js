


async function bootstrapCbtApp() {
    const CbtModule = await import("./modules/cbt/cbt.js");
    Vue.createApp(CbtModule.CbtApp)
        .mount("#cbt-app");
}
async function bootstrapStudentCbtApp() {
    const StudentCbtModule = await import("./modules/student-cbt/index.js");
    Vue.createApp(StudentCbtModule.StudentCbtApp)
        .mount("#student-cbt-app");
}
async function bootstrapCbtResultApp() {
    const CbtResultModule = await import("./modules/cbt/results/index.js");
    Vue.createApp(CbtResultModule.CbtResultApp)
        .mount("#cbt-result-app");
}

if (document.querySelector("#cbt-app")) {
    bootstrapCbtApp();
}

if (document.querySelector("#student-cbt-app")) {
    bootstrapStudentCbtApp();
}

if (document.querySelector("#cbt-result-app")) {
    bootstrapCbtResultApp();
}

function printme() {
    window.print()
}

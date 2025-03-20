import robot from 'robotjs';
async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

robot.getMousePos();

//move mouse to bambulabs button and click
robot.setMouseDelay(2);
robot.moveMouse(-449, 203);
robot.mouseClick();
await sleep(20000)
console.log('slept')
//moves to top right corner to click Prepare button
robot.moveMouse(-1820, -800);
robot.mouseClick();
await sleep(2000)
//moves to add project in
robot.moveMouse(-1241, -753);
robot.mouseClick();
console.log('project added')
await sleep(5000)
robot.moveMouse(-1775, -802);
robot.mouseClick();
await sleep(5000)
robot.moveMouse(-1687, -651);
robot.mouseClick();
robot.moveMouse(-1692, -408);
robot.mouseClick();
setTimeout(() => {
    robot.mouseClick();
}, 100);
robot.moveMouse(-1654, -687);
robot.mouseClick();
setTimeout(() => {
    robot.mouseClick();
});
robot.moveMouse(-1654, -687);
robot.mouseClick();
setTimeout(() => {
    robot.mouseClick();
});
robot.moveMouse(-1643, -691);
robot.mouseClick();
setTimeout(() => {
    robot.mouseClick();
});
await sleep(5000)
robot.moveMouse(-276, -793);
robot.mouseClick();
console.log('clicked slice plate')
await sleep(15000)
robot.moveMouse(-97, -801);
robot.mouseClick();
console.log('clicked print')
await sleep(1000)
robot.moveMouse(-146, -714);
robot.mouseClick();
console.log(' going to click the time lapse')
await sleep(2000)
robot.moveMouse(-1117, -37);
robot.mouseClick();
console.log('clicked print')
robot.moveMouse(-809,39)
robot.mouseClick();







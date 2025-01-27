// Gestion du timer
export default class Timer {
    constructor(duration, onTick, onTimeout) {
        this.duration = duration;
        this.remaining = duration;
        this.timerId = null;
        this.onTick = onTick;
        this.onTimeout = onTimeout;
    }

    start() {
        this.remaining = this.duration;
        this.onTick(this.remaining);

        this.timerId = setInterval(() => {
            this.remaining--;
            this.onTick(this.remaining);

            if (this.remaining <= 0) {
                this.stop();
                this.onTimeout();
            }
        }, 1000);
    }

    stop() {
        if (this.timerId) {
            clearInterval(this.timerId);
            this.timerId = null;
        }
    }

    reset() {
        this.stop();
        this.remaining = this.duration;
    }
}
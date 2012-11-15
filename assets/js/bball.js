/* bball.js - HTML5 basketball game
 * Copyright (C) 2012 Florian Hülsmann <fh@cbix.de>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
window.requestAnimFrame = (function(callback) {
    return window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.oRequestAnimationFrame ||
    window.msRequestAnimationFrame ||
    function(callback) {
        window.setTimeout(callback, 1000 / 60);
    };
})();
function BBall(canvas) {
    this.canvas = canvas;
    this.brect = canvas.getBoundingClientRect();
    this.ctx = this.canvas.getContext('2d');
    this.ctx.font = '18pt Calibri';
    this.ctx.textBaseline = 'top';
    this.ctx.strokeStyle = 'black';
    this.drawLine = false;
    this.line = {};
    this.physicalBall = true;
    this.isAnimated = true;
    this.ball = {
        radius: 20,
        x: this.canvas.width / 2,
        y: this.canvas.height / 2,
        vx: 200 * Math.random() - 100,
        vy: 200 * Math.random() - 100
    };
    var that = this;
    this.canvas.addEventListener('mousedown', function(event) {
        var pos = that.getEventPos(event);
        if(Math.sqrt((pos.x - that.ball.x) * (pos.x - that.ball.x) + (pos.y - that.ball.y) * (pos.y - that.ball.y)) <= that.ball.radius) {
            // clicked on ball
            that.drawLine = true;
            that.physicalBall = false;
            if(!that.isAnimated) {
                that.isAnimated = true;
                that.animate(new Date().getTime());
            }
            that.line = pos;
        }
    });
    this.canvas.addEventListener('touchstart', function(event) {
        var pos = that.getEventPos(event.touches[0]);
        if(Math.sqrt((pos.x - that.ball.x) * (pos.x - that.ball.x) + (pos.y - that.ball.y) * (pos.y - that.ball.y)) <= that.ball.radius) {
            // touched on ball
            that.drawLine = true;
            that.physicalBall = false;
            if(!that.isAnimated) {
                that.isAnimated = true;
                that.animate(new Date().getTime());
            }
            that.line = pos;
        }
    });
    document.addEventListener('mousemove', function(event) {
        if(that.drawLine) {
            that.line = that.getEventPos(event);
        }
    });
    document.addEventListener('touchmove', function(event) {
        if(that.drawLine) {
            event.preventDefault();
            that.line = that.getEventPos(event.touches[0]);
        }
    });
    document.addEventListener('mouseup', function(event) {
        if(that.drawLine) {
            that.line = that.getEventPos(event);
            that.drawLine = false;
            that.ball.vx = 5 * (that.line.x - that.ball.x);
            that.ball.vy = 5 * (that.line.y - that.ball.y);
            console.log('shoot, ball(', Math.floor(that.ball.x), '|', Math.floor(that.ball.y), '), v(', Math.floor(that.ball.vx), '|', Math.floor(that.ball.vy) , '), line(', Math.floor(that.line.x), '|', Math.floor(that.line.y), ')');
            that.physicalBall = true;
        }
    });
    document.addEventListener('touchend', function(event) {
        if(that.drawLine) {
            that.line = that.getEventPos(event.touches[0]);
            that.drawLine = false;
            that.ball.vx = 5 * (that.line.x - that.ball.x);
            that.ball.vy = 5 * (that.line.y - that.ball.y);
            that.physicalBall = true;
        }
    });
    this.animate(new Date().getTime());
}
BBall.GRAVITY = 500;
BBall.BOUNCE = 0.8; // Ball has 80% of its energy after collision
BBall.prototype.getEventPos = function(event) {
    // FIXME for document.addEventListener!!!!!!
    //var x = event.clientX - this.canvas.offsetLeft - document.documentElement.scrollLeft;
    //var y = event.clientY - this.canvas.offsetTop - document.documentElement.scrollTop;
	var x = event.clientX - this.canvas.offsetLeft + window.pageXOffset;
	var y = event.clientY - canvas.offsetTop + window.pageYOffset;
	console.log("event info:", {x: x, y: y});
    return {x: x, y: y};
};
BBall.prototype.resize = function() {
    this.brect = this.canvas.getBoundingClientRect();
    this.ball.radius = 20;
    this.ball.x = Math.min(this.canvas.width - this.ball.radius, this.ball.x);
    this.ball.y = Math.min(this.canvas.height - this.ball.radius, this.ball.y);
    this.physicalBall = true;
    this.isAnimated = true;
    this.animate(new Date().getTime());
};
BBall.prototype.drawWorld = function() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    //ball
    this.ctx.beginPath();
    this.ctx.arc(this.ball.x, this.ball.y, this.ball.radius, 0, 2 * Math.PI, false);
    this.ctx.fillStyle = 'orange';
    this.ctx.fill();
    if(this.drawLine) {
        this.ctx.beginPath();
        this.ctx.moveTo(this.ball.x, this.ball.y);
        this.ctx.lineTo(this.line.x, this.line.y);
        this.ctx.stroke();
    }
};
BBall.prototype.updateBall = function(timeDiff) {
    this.ball.x += timeDiff * this.ball.vx / 1000;
    this.ball.vy += timeDiff * BBall.GRAVITY / 1000;
    this.ball.y += timeDiff * this.ball.vy / 1000;
    if(this.ball.x < this.ball.radius) {
        this.ball.x = this.ball.radius;
        this.ball.vx *= -BBall.BOUNCE;
    }
    if(this.ball.x > this.canvas.width - this.ball.radius) {
        this.ball.x = this.canvas.width - this.ball.radius;
        this.ball.vx *= -BBall.BOUNCE;
    }
    if(this.ball.y > this.canvas.height - this.ball.radius) {
        this.ball.y = this.canvas.height - this.ball.radius;
        this.ball.vy *= -BBall.BOUNCE;
        this.ball.vx *= BBall.BOUNCE;
    }
    if(Math.abs(this.ball.vx) < 3 && Math.abs(this.ball.vy) < 3 && this.ball.y + this.ball.radius == this.canvas.height) {
        this.ball.vx = 0;
        this.ball.vy = 0;
        this.physicalBall = false;
        this.isAnimated = this.drawLine;
    }
};
BBall.prototype.animate = function(timeStart) {
    var time = new Date().getTime();
    if(this.physicalBall) {
        this.updateBall(time - timeStart);
    }
    this.drawWorld();
    if(this.isAnimated) {
        var that = this;
        requestAnimFrame(function() {
            that.animate(time);
        });
    }
};

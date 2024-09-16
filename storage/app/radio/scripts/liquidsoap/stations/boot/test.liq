#!/usr/bin/liquidsoap
settings.init.allow_root := true

settings.request.metadata_decoders.set(["FFMPEG"])
settings.request.metadata_decoders.duration.set(false)
log("Duration metadata decoding disabled")

settings.server.telnet.set(true)
settings.server.timeout.set(-1.0)
settings.server.telnet.bind_addr.set("0.0.0.0")
settings.harbor.bind_addrs.set(["0.0.0.0"])

settings.log.level.set(1)
settings.server.log.level.set(1)
settings.log.stdout.set(true)

settings.ffmpeg.log.level.set(1)
settings.ffmpeg.log.verbosity.set("warning")

enable_replaygain_metadata()

server.harbor()
interactive.harbor()

# Create a source that streams MP3 data from the URL
# /next returns the next track to play
radio = mksafe(input.http("https://cream-api/api/stations/1/next"))

# Encode the source for streaming (e.g., MP3 at 128kbps)
output.icecast(
  %mp3,
  host = "cream-cast",
  port = 8004,
  password = "hackme",
  mount = "/test.mp3",
  name = "test",
  description = "No description",
  genre = "No genre",
  public = true,
  url = "https://cream-cast:8004/test.mp3",
  radio
)
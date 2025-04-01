<?php

declare(strict_types=1);

/**
 * This file is part of the MultiFlexi package
 *
 * https://github.com/VitexSoftware/AbraFlexi-RelationshipOverview
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AbraFlexi\Relationship\ui;

/**
 * Description of AppLogo.
 *
 * @author Vitex <info@vitexsoftware.cz>
 */
class AppLogo extends \Ease\Html\ImgTag
{
    public function __construct($properties = [])
    {
        parent::__construct('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhLS0gQ3JlYXRlZCB3aXRoIElua3NjYXBlIChodHRwOi8vd3d3Lmlua3NjYXBlLm9yZy8pIC0tPgoKPHN2ZwogICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgIHhtbG5zOmNjPSJodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9ucyMiCiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIKICAgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIgogICB4bWxuczpzb2RpcG9kaT0iaHR0cDovL3NvZGlwb2RpLnNvdXJjZWZvcmdlLm5ldC9EVEQvc29kaXBvZGktMC5kdGQiCiAgIHhtbG5zOmlua3NjYXBlPSJodHRwOi8vd3d3Lmlua3NjYXBlLm9yZy9uYW1lc3BhY2VzL2lua3NjYXBlIgogICBoZWlnaHQ9IjQ4IgogICB3aWR0aD0iNDgiCiAgIHZlcnNpb249IjEuMSIKICAgdmlld0JveD0iMCAwIDEyLjcgMTIuNyIKICAgaWQ9InN2ZzE2IgogICBzb2RpcG9kaTpkb2NuYW1lPSJwcm9qZWN0LWxvZ28uc3ZnIgogICBpbmtzY2FwZTp2ZXJzaW9uPSIwLjkyLjEgcjE1MzcxIj4KICA8ZGVmcwogICAgIGlkPSJkZWZzMjAiIC8+CiAgPHNvZGlwb2RpOm5hbWVkdmlldwogICAgIHBhZ2Vjb2xvcj0iI2ZmZmZmZiIKICAgICBib3JkZXJjb2xvcj0iIzY2NjY2NiIKICAgICBib3JkZXJvcGFjaXR5PSIxIgogICAgIG9iamVjdHRvbGVyYW5jZT0iMTAiCiAgICAgZ3JpZHRvbGVyYW5jZT0iMTAiCiAgICAgZ3VpZGV0b2xlcmFuY2U9IjEwIgogICAgIGlua3NjYXBlOnBhZ2VvcGFjaXR5PSIwIgogICAgIGlua3NjYXBlOnBhZ2VzaGFkb3c9IjIiCiAgICAgaW5rc2NhcGU6d2luZG93LXdpZHRoPSIxMDI5IgogICAgIGlua3NjYXBlOndpbmRvdy1oZWlnaHQ9Ijc4NiIKICAgICBpZD0ibmFtZWR2aWV3MTgiCiAgICAgc2hvd2dyaWQ9ImZhbHNlIgogICAgIGlua3NjYXBlOnpvb209IjMuNDc2NjA4MyIKICAgICBpbmtzY2FwZTpjeD0iNTAuMjI3OTE4IgogICAgIGlua3NjYXBlOmN5PSItMjMuNTQwODkxIgogICAgIGlua3NjYXBlOndpbmRvdy14PSI3MDEiCiAgICAgaW5rc2NhcGU6d2luZG93LXk9IjIwMyIKICAgICBpbmtzY2FwZTp3aW5kb3ctbWF4aW1pemVkPSIwIgogICAgIGlua3NjYXBlOmN1cnJlbnQtbGF5ZXI9InN2ZzE2IiAvPgogIDxtZXRhZGF0YQogICAgIGlkPSJtZXRhZGF0YTIiPgogICAgPHJkZjpSREY+CiAgICAgIDxjYzpXb3JrCiAgICAgICAgIHJkZjphYm91dD0iIj4KICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD4KICAgICAgICA8ZGM6dHlwZQogICAgICAgICAgIHJkZjpyZXNvdXJjZT0iaHR0cDovL3B1cmwub3JnL2RjL2RjbWl0eXBlL1N0aWxsSW1hZ2UiIC8+CiAgICAgICAgPGRjOnRpdGxlPjwvZGM6dGl0bGU+CiAgICAgIDwvY2M6V29yaz4KICAgIDwvcmRmOlJERj4KICA8L21ldGFkYXRhPgogIDxnCiAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCwtMjg0LjMpIgogICAgIGlkPSJnMTQiPgogICAgPGcKICAgICAgIHN0eWxlPSJpbWFnZS1yZW5kZXJpbmc6b3B0aW1pemVRdWFsaXR5O3NoYXBlLXJlbmRlcmluZzpnZW9tZXRyaWNQcmVjaXNpb24iCiAgICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCguMDE1NjA5IDAgMCAtLjAxNTYwOSAtMTguMjUxIDI5NC4zMSkiCiAgICAgICBpZD0iZzEyIj4KICAgICAgPHBhdGgKICAgICAgICAgZD0ibTE3MDguNyAwIDEzMy44IDIzMS42MiAxMzMuNy0yMzEuNjJ6IgogICAgICAgICBmaWxsPSIjZjlhZTJkIgogICAgICAgICBpZD0icGF0aDQiIC8+CiAgICAgIDxwYXRoCiAgICAgICAgIGQ9Im0xNzA4LjcgMC0xMzMuNzUgMjMxLjYyaDI2Ny41M3oiCiAgICAgICAgIGZpbGw9IiNkMjhiMjUiCiAgICAgICAgIGlkPSJwYXRoNiIgLz4KICAgICAgPHBhdGgKICAgICAgICAgZD0ibTE1NzQuOSAyMzEuNjIgMTMzLjc1IDIzMS42OCAxMzMuNzgtMjMxLjY4eiIKICAgICAgICAgZmlsbD0iIzkzNjMyNyIKICAgICAgICAgaWQ9InBhdGg4IiAvPgogICAgICA8cGF0aAogICAgICAgICBkPSJtMTcwOC43IDQ2My4zaC0yNjcuNWwtMjY3LjYtNDYzLjNoMjY3LjU2bDI2Ny40NyA0NjMuMyIKICAgICAgICAgZmlsbD0iIzc2N2E3YyIKICAgICAgICAgaWQ9InBhdGgxMCIgLz4KICAgIDwvZz4KICA8L2c+CiAgPGcKICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjAxMzIxMDYzLDAsMCwwLjAxMzY2NTIxLDAuNzMxOTg5NzUsLTguNTg1ODQwNykiCiAgICAgaWQ9ImczOSIKICAgICBzdHlsZT0iZmlsbDojZmZkNWQ1Ij4KICAgIDxwYXRoCiAgICAgICBzdHlsZT0iZmlsbDojZmZkNWQ1IgogICAgICAgaW5rc2NhcGU6Y29ubmVjdG9yLWN1cnZhdHVyZT0iMCIKICAgICAgIGQ9Im0gNDIwLjQsOTc3LjUzIC0xMTcuNjcsMTkuNzkyIC0yNS44MjcsMjkuNTUxIC0xMDYuMjEsMC44MzM0IGMgLTcuNDIzLDUyLjQzOSAtMTUuNjMsMTA1LjU5IC0yLjc0NiwxNTguOTkgbCA3NC40NjMsLTEuNDA0NyAxMS43NTIsMC4xMzg5IC0xMi41ODUsMTkuNzExIGMgLTEuMjUyLDcuMDk2OCAxLjQwMDksOS40NjgyIDMuMTUwNSwxMi45MzMgbCAzMC44NzgsMTQuOTkyIGMgMTQuODgzLDguMzM4OCAzMy43NDIsOC40ODk5IDUxLjc3NywxMC4zMzYgMi4yMDY3LDQuNjE2MSA0LjIyNzYsOS4yMjM0IDguMzY3NSwxMy45MyBsIDI1LjYxOCwtMS4wNDg1IGMgNS4wOTQsMTEuMjE0IDEyLjI5LDE1LjQzNiAxOC40NjYsMjMuMDU0IGwgNTIuNTM4LC01Ljc5NTcgNC44NTU3LC03LjI5MTMgYyA2LjM5NiwyLjU3NjcgMTQuMzE1LDEuNjc4NCAyMC44NzcsMC43MzQyIGwgLTEuNTc3MSwwLjAyMyBjIDE0LjU3LC0wLjE2MiAyMy4xMzIsLTkuNjMzNCAzMy4zNTcsLTE2LjUyNyAxMi40NzEsMi45NjYyIDExLjg4NCwtMS4yMTk0IDI1LjU2MiwtMTcuMjQ2IGwgNC43OTgyLC01LjE4MjkgYyAyLjk2NjEsMC44OTE5IDUwLjgzOSwtOS42MzU5IDUwLjgzOSwtOS42MzU5IGwgMjcuODUzLC0zMi41MjggOTMuMSwtMC41NzYzIGMgMTEuOTIyLC00Ni4yODEgNy4xNiwtOTUuNTIyIC0yLjQ5MTQsLTE1MC44MiBsIC05NC43OSwwLjc5NjIgLTM0LjgwNywtMjkuMjkgYyAtMzMuODM1LC00LjQ0OTkgLTY2LjkxMiwtOC42NCAtMTA2LjMxLC0xOS41MTkgbCAtMTIuMDYsOC44MDY3IC01Ljg0NDEsMi4zOTI3IC0xNS42NzUsLTE5Ljg1NCIKICAgICAgIGlkPSJwYXRoMzEiIC8+CiAgICA8ZwogICAgICAgc3R5bGU9ImZpbGw6I2ZmZDVkNTtzdHJva2U6IzAwNDU4MjtzdHJva2UtbGluZWNhcDpyb3VuZDtzdHJva2UtbGluZWpvaW46cm91bmQiCiAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjk5ODg5LDAuMDQ3MDgyLC0wLjA0NzA4MiwwLjk5ODg5LC02MDkuMTcsNTg3Ljk5KSIKICAgICAgIGlkPSJnMzciPgogICAgICA8cGF0aAogICAgICAgICBzdHlsZT0iZmlsbDojZmZkNWQ1O3N0cm9rZS13aWR0aDoxMC4xMzE5OTk5NyIKICAgICAgICAgaW5rc2NhcGU6Y29ubmVjdG9yLWN1cnZhdHVyZT0iMCIKICAgICAgICAgZD0ibSAxMTU4LjMsNTg2LjE4IGMgMy4wMDQ4LDAuNzUxMTcgNTAuMzI5LC0xMi4wMTkgNTAuMzI5LC0xMi4wMTkgbCAyNi4yOTEsLTMzLjgwMyA5Mi45NywtNC45NTkgYyA5LjcyOTUsLTQ2Ljc5MSAyLjY1NDcsLTk1Ljc1MyAtOS41ODk0LC0xNTAuNTMgbCAtOTQuNjQ4LDUuMjU4MiAtMzYuMTQ4LC0yNy42MTkgYyAtMzQuMDA3LC0yLjg1MTkgLTY3LjI0NCwtNS40ODAxIC0xMDcuMTEsLTE0LjQ5MiBsIC0xOC4wMiwxMi45NDQgbSAxNC43OTYsMjY3LjI5IGMgNi41MTAyLDIuMjcyNyAxMy4wMiwyLjAwMzIgMTkuNTMsMC43NTExOCBtIC0xNjYuMzcsLTU1Ljk2IC0xNi41MywyNy43OSBtIDE1MS43NCwtMzMuMDUyIC0zMy40MjcsNDguODI2IC0zMy40MjcsNS42MzM4IG0gMjAuMjgyLC02OC4zNTcgLTQ4LjgyNiw1Ni43MTQgbSAxMjkuNTgsLTI4LjkyIGMgLTguMDM3OSwxOS40OTIgLTE2LjIyNiwzOC43NiAtMjcuMDQyLDU0LjA4NCBsIC01Mi4yMDcsOC4yNjI5IGMgLTYuNTI2OSwtNy4zMTk2IC0xMy45MTQsLTExLjE5NyAtMTkuNTMsLTIyLjE2IGwgLTI1LjU0LDIuMjUzNSBjIC00LjM1NjksLTQuNTA3IC02LjU5MjUsLTkuMDE0MSAtOS4wMTQxLC0xMy41MjEgLTE4LjEwMiwtMC45OTUzOSAtMzYuOTQ3LC0wLjI1ODQ0IC01Mi4yMDcsLTcuODg3MyBsIC0zMS41NDksLTEzLjUyMSBjIC0xLjkxMDgsLTMuMzc4MiAtNC42NzI0LC01LjYyMjEgLTMuNzU1OSwtMTIuNzcgbCAxMS42NDMsLTIwLjI4MiBtIDIyMC40NywtODkuMzkgNDUuODIyLDUxLjgzMSA3Ljg4NzMsNTcuODQgbSAtODUuMjU4LC02Ny4yMyBjIDAuNzUxMiwxLjg3NzkgNDkuMjAyLDUyLjIwNyA0OS4yMDIsNTIuMjA3IGwgMC4zNzU2LDQ4LjQ1MSAtMC4zNzU2LC0wLjM3NTU5IG0gLTgxLjg1OSwtMjY4LjgzIC0xMTYuNjEsMjUuMzExIC0yNC40MDcsMzAuNzM0IC0xMTAuODQsNi4wNTg4IGMgLTQuOTQ1OCw1Mi43MzEgLTkuMDQzLDEwNi4xNCA2LjM0MDgsMTU4Ljg3IGwgMTE1LjgxLC03LjMzMyAxMi40MiwxNi4yMiBjIDMuNzU2Nyw0LjU0MiA4LjQxNjYsNS40NzEgMTMuMTU4LDYuMDczNiBsIDUxLjIxNSwtNDEuNzQzIGMgMTAuOTQ1LDQuNjMzMiAxNi43MTgsMTMuNTc5IDIzLjk5MSwyMC4wNDggOS41NzM1LC04LjM5NDggMTguMzksLTE0Ljk1NiAyNi45NjMsLTE4LjM0NyAxMi43NzksNi42MzUyIDE2LjU4NiwxMi4zNzMgMjIuNzU0LDE4LjM0NyBsIC0yLjcxMTgsMTIuNjU1IDExLjU5MywtNi4xMTMyIDIxLjg1MywxNy44NjUgLTEuODA3OSw0OC44MTQgYyAxNC41NDYsLTAuODQ3NzcgMjIuNjUzLC0xMC43MTIgMzIuNTQyLC0xOC4wNzkgMTIuNTk3LDIuMzc1OCAyMi4zNDYsLTE2Ljc5MyAzNS4yNTQsLTMzLjQ0NiAxMy41NDMsLTkuMzQwOSAxOC45MjEsLTE4LjY4MiAyOC4wMjMsLTI4LjAyMyBsIC0wLjkwNCwtNzAuNTA4IC04MC45OCwtNjMuNSBjIC0xMS4wNjgsNi43MDk3IC0yMS44NjMsMTguNDM5IC0zMy44MjIsMTkuODA0IC00LjQyMjgsOS40OTA1IC02LjgyODMsMTguMDg0IC0yMC43OTEsMjQuNzEyIC05LjAyNDcsOC42NjU1IC0yNS4xNzgsMTIuNzk0IC00NS4xOTgsMTQuNDYzIGwgLTI0LjQwNywtMjAuNzkxIDM2LjE1OCwtMzQuMzUgOC4xMzU2LC0zMi41NDIgMzIuNTQyLC0yNS43OTEgLTE2LjU5MywtMTkuMDk0IgogICAgICAgICBpZD0icGF0aDMzIiAvPgogICAgICA8cGF0aAogICAgICAgICBzdHlsZT0iZmlsbDojZmZkNWQ1O3N0cm9rZS13aWR0aDo1Ljc4OTUwMDI0IgogICAgICAgICBpbmtzY2FwZTpjb25uZWN0b3ItY3VydmF0dXJlPSIwIgogICAgICAgICBkPSJtIDEwMzkuMiw0MzQuNDUgYyAtNS4yNDcsNy42MDMyIC05LjYzODUsMTIuNjQgLTEzLjg5NywxNy4yNzcgLTEwLjY0MiwwLjM1NDgzIC0yMS4yODMsMi4xMDY4IC0zMS45MjUsLTIuMjUzNSB2IDAuMzc1NTkgbSAxNzguODQsNDYuNjA3IGMgLTUuMTMyOSw2LjEzOSAtMTEuMDcsMTEuNzQyIC0xOC4zMjUsMTYuNDY2IG0gLTYuOTA1LDMyLjkzMiBjIC00LjkzMDIsNi4zOTQ1IC0xMC4yOTcsMTEuMDQyIC0xNS45MzUsMTQuNjA3IG0gLTMxLjA3MywyMS4yNDYgYyA0LjQ4NjksMi4xNDA0IDI5LjAwNSwtMjAuMTQ5IDI2LjgyNCwtMjEuNTEyIG0gLTE4My43OCwxOS4xMjIgYyA0Ljc3ODQsNi43MjkxIDEwLjk3OSwxMi43NDcgMTguNTkxLDE4LjA1OSBtIDMwLjgwNywtOC4yMzMgYyA2LjAxMDEsNi40MjE1IDEwLjY1NSwxMi45NTYgMjEuNTEyLDE5LjY1MyBtIDE5LjEyMiwxMC4zNTggYyAxLjMyOCwxLjMyNzkgMTQuMDc2LDExLjk1MSAxNC4wNzYsMTEuOTUxIG0gMjUuMjMsLTU0LjcwOSBjIC0zLjY5MTcsNC43ODA0IC02LjU2NTcsOS41NjA5IC03LjQzNjMsMTQuMzQxIDQuMzY1Niw1LjE5NTMgOS40NDk3LDkuNjcyIDE1LjkzNSwxMi43NDggbSAtMzkuMDQsLTUyLjg1IGMgLTMuMDQ2MiwtMC4yNDc5OSAtMTguMTg4LDE1LjQ4NyAtMTQuNjA3LDE1LjkzNSAzLjY4OSw2LjU5OTQgOS4zNjY1LDkuODg0OCAxNS4xMzgsMTMuMDEzIG0gLTUxLjUyMiwtMzIuOTMyIGMgLTYuMTEwNiw1LjEzNDYgLTEyLjk4NCwxMC4yNjkgLTE0LjM0MSwxNS40MDQgMy42NzI0LDUuNzU3MiA5LjA2OSw4LjA2NiAxNC4wNzYsMTEuMTU0IgogICAgICAgICBpZD0icGF0aDM1IiAvPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg==', _('Relationship overview'), $properties);
    }
}

@extends('main')

@section('content')
<div class="fourteen wide column">
	<div class="ui two column center aligned stackable divided grid">
		<div class="column">
			<div class="ui icon header">
				<i class="comments icon"></i> Project Description
			</div>
			<div class="ui segment">
				<p align="justify">
					O YouInteract é um sistema de interação com ecrãs públicos através de gestos usando um Kinect. Este sistema, tem sido desenvolvido no Departamento de Eletrónica, Telecomunicações e Informática da Universidade de Aveiro desde o ano 2009, para vários propósitos: teses de mestrado, bolsas de iniciação à investigação e na unidade curricular de Projeto em Engenharia Informática.
				</p>
				<p align="justify">
					Muitas foram as funcionalidades acrescidas a este projeto desde o seu início. No presente ano, tencionamos tornar algumas aplicações interativas entre diferentes Kinect, adaptar o portal existente a organizações externas ao nosso departamento (criando aplicações genéricas e de fácil configuração), permitir agendamento entre monitores com e sem Kinect e melhorar o portal já existente.
				</p>
				<p align="justify">
					O objetivo deste projeto é desenvolver o YouInteract tornando-o numa aplicação standalone que possa ser facilmente configurada e instalada em qualquer local.
				</p>
				<center>
					<img src="/images/logoYI.png" class="ui small image">
				</center>
			</div>
		</div>
		<div class="column">
			<div class="ui icon header">
				<i class="users icon"></i> Development Team
			</div>
			<table class="ui small table">
				<thead>
					<tr>
						<th>Name</th>
						<th>E-mail</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Claúdio Samuel Horta Patrício </td>
						<td>cpatricio@ua.pt</td>
					</tr>
					<tr>
						<td>João Miguel Minhós Rodrigues</td>
						<td>miguelminhos@ua.pt</td>
					</tr>
					<tr>
						<td>Leonardo Fernandes Pinheiro </td>
						<td>leonardo.pinheiro@ua.pt</td>
					</tr>
					<tr>
						<td>Pedro António Carvalho Abade </td>
						<td>abade.p@ua.pt</td>
					</tr>
					<tr>
						<td>Rui Pedro dos Santos Oliveira </td>
						<td>ruipedrooliveira@ua.pt</td>
					</tr>
					<tr>
						<td>Tomás Marques Rodrigues </td>
						<td>tomasrodrigues@ua.pt</td>
					</tr>
				</tbody>
			</table>
			<div class="ui icon header">
				<i class="student icon"></i> Lecturers
			</div>
			<table class="ui small table">
				<thead>
					<tr>
						<th>Name</th>
						<th>E-mail</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Paulo Miguel de Jesus Dias</td>
						<td>paulo.dias@ua.pt</td>
					</tr>
					<tr>
						<td>José Maria Amaral Fernandes </td>
						<td>jfernan@ua.pt</td>
					</tr>
					<tr>
						<td>Diogo Nuno Pereira Gomes </td>
						<td>dgomes@ua.pt</td>
					</tr>
					<tr>
						<td>João Paulo Silva Barraca </td>
						<td>jpbarraca@ua.pt</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

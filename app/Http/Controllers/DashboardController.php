<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
       
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        $dateDebut = $date->copy()->startOfDay();
        $dateFin = $date->copy()->endOfDay();
        $restaurant = Restaurant::first();
        
       
        $enCours = Commande::whereBetween('date_commande', [$dateDebut, $dateFin])
                    ->whereIn('statut', ['en attente', 'en préparation', 'prête'])
                    ->count();
                    
        $validees = Commande::whereBetween('date_commande', [$dateDebut, $dateFin])
                    ->where('statut', 'payée')
                    ->count();
                    
        $recette = Commande::whereBetween('date_commande', [$dateDebut, $dateFin])
                    ->where('statut', 'payée')
                    ->sum('total');
                    
       
        $hierDebut = $dateDebut->copy()->subDay()->startOfDay();
        $hierFin = $dateDebut->copy()->subDay()->endOfDay();
        
        $recetteHier = Commande::whereBetween('date_commande', [$hierDebut, $hierFin])
                        ->where('statut', 'payée')
                        ->sum('total');
                        
        $evolution = $recetteHier > 0 
                    ? round((($recette - $recetteHier) / $recetteHier) * 100, 1) 
                    : 100;
        
        
        $burgersVendus = DB::table('commandes_burgers')
                        ->join('commandes', 'commandes_burgers.commande_id', '=', 'commandes.id')
                        ->whereBetween('commandes.date_commande', [$dateDebut, $dateFin])
                        ->where('commandes.statut', 'payée')
                        ->sum('commandes_burgers.quantite');
                        
       
        $burgersVendusHier = DB::table('commandes_burgers')
                           ->join('commandes', 'commandes_burgers.commande_id', '=', 'commandes.id')
                           ->whereBetween('commandes.date_commande', [$hierDebut, $hierFin])
                           ->where('commandes.statut', 'payée')
                           ->sum('commandes_burgers.quantite');
                        
        $evolutionBurgers = $burgersVendusHier > 0 
                          ? round((($burgersVendus - $burgersVendusHier) / $burgersVendusHier) * 100, 1) 
                          : 100;
        
        $commandes = DB::table('commandes')
                    ->join('users', 'commandes.user_id', '=', 'users.id')
                    ->select(
                        'commandes.id',
                        'commandes.statut',
                        'commandes.total',
                        'commandes.date_commande',
                        'commandes.type',
                        'users.nom as user_name',
                        'users.email as user_email'
                    )
                    ->orderBy('commandes.date_commande', 'desc')
                    ->take(5)
                    ->get();
        
        
        $burgersPopulaires = DB::table('burgers')
                           ->leftJoin('commandes_burgers', 'burgers.id', '=', 'commandes_burgers.burger_id')
                           ->leftJoin('commandes', 'commandes_burgers.commande_id', '=', 'commandes.id')
                           ->select(
                               'burgers.id',
                               'burgers.nom',
                               'burgers.prix',
                               'burgers.image',
                               DB::raw('SUM(CASE WHEN commandes.statut = \'payée\' THEN commandes_burgers.quantite ELSE 0 END) as vendu')
                           )
                           ->groupBy('burgers.id', 'burgers.nom', 'burgers.prix', 'burgers.image')
                           ->orderBy('vendu', 'desc')
                           ->take(4)
                           ->get();
        
        
        $commandesMois = DB::table('commandes')
                        ->select(
                            DB::raw('to_char(date_commande, \'Mon YYYY\') as mois'),
                            DB::raw('COUNT(*) as total')
                        )
                        ->where('statut', 'payée')
                        ->where('date_commande', '>=', Carbon::now()->subMonths(6))
                        ->groupBy('mois')
                        ->orderBy(DB::raw('MIN(date_commande)'))
                        ->get();
        
        
        $burgerCategories = DB::table('commandes_burgers')
                          ->join('commandes', 'commandes_burgers.commande_id', '=', 'commandes.id')
                          ->join('burgers', 'commandes_burgers.burger_id', '=', 'burgers.id')
                          ->select(
                              'burgers.nom as categorie',
                              DB::raw('SUM(commandes_burgers.quantite) as total')
                          )
                          ->where('commandes.statut', 'payée')
                          ->where('commandes.date_commande', '>=', Carbon::now()->subMonths(1))
                          ->groupBy('burgers.nom')
                          ->orderBy('total', 'desc')
                          ->take(5)
                          ->get();
        
        return view('dashboard.index', compact(
            'enCours', 
            'validees', 
            'recette', 
            'evolution',
            'burgersVendus',
            'evolutionBurgers',
            'commandes',
            'burgersPopulaires',
            'commandesMois',
            'burgerCategories',
            'restaurant'
        ));
    }
}